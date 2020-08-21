DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `event_checkin`(IN hash CHAR(32), IN userID INT(6))
BEGIN
	IF (SELECT COUNT(events.id) FROM events WHERE events.hash = hash ) = 0 THEN
		SELECT 2002 as errc;
	ELSE
		SELECT 		events.name,
					events.id,
					events.points,
					events.dtStart,
					events.dtEnd,
                    IFNULL(binds.role,0),
					IFNULL(roles.name,'Участник')
		INTO		@name,
					@evid,
					@points,
					@dtStart,
					@dtEnd,
                    @role,
                    @roleName
		FROM    	events
        
        LEFT JOIN	roles_binds binds
		ON			binds.userid = userID
		AND			binds.eventid = events.id
        
        LEFT JOIN	roles
		ON			roles.id = binds.role
        
		WHERE	events.hash = hash;
		IF (SELECT COUNT(checkins.id) FROM checkins WHERE checkins.userid = userID AND checkins.eventid = @evid) > 0 THEN
			SELECT 2001 as errc;
		ELSEIF (@dtStart > DATE(CURRENT_TIMESTAMP)) = 1 THEN
			SELECT 2003 as errc,  @dtStart as dtStart;
		ELSEIF (@dtEnd < DATE(CURRENT_TIMESTAMP)) = 1 THEN
			SELECT 2004 as errc,  @dtEnd as dtEnd;
		ELSE
			INSERT INTO checkins(
				`userid`, `eventid`, `points`
			) 
			VALUES (	
				userID, @evid, @points
			);
			SELECT 0 AS errc, @evid as id, @points as points, @name as name, @role as role, @roleName as roleName;	
		END IF;
	END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `event_load_checkers`(IN eventID INT(5))
BEGIN
	SELECT 		checkins.points,
				checkins.userid,
                checkins.dtAdded,
				users.login,
                users.id,
				users.email,
                IFNULL(binds.role,0) as role,
                IFNULL(roles.name,'Участник') as roleName,
                inst.name as instituteName
	FROM 		checkins
	LEFT JOIN	users
	ON			users.id = checkins.userid
    
    LEFT JOIN	institutes inst
	ON			inst.id = users.instituteID
    
	LEFT JOIN	roles_binds binds
	ON			binds.userid = users.id
    AND			binds.eventid = eventID
    
	LEFT JOIN	roles
	ON			roles.id = binds.role
    
	WHERE		checkins.eventid = eventID;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `event_update`(IN eventID INT(5),IN name CHAR(32),IN points INT(5),IN dtStart CHAR(16),IN dtEnd CHAR(16))
BEGIN
	UPDATE 	`events`
    SET		events.name = name,
			events.points = points,
            events.dtStart = dtStart,
            events.dtEnd = dtEnd
	WHERE	events.id = eventID;
    SELECT 0 AS errc;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `event_load_admin`(IN eventID INT(5))
BEGIN
	SELECT 		0 as errc,
				events.name as name,
                events.hash as hash,
				events.points as points,
                events.dtStart as dtStart,
                events.dtEnd as dtEnd,
                (SELECT  count(checkins.id) FROM  checkins WHERE  checkins.eventid = eventID) as usersChecked
		FROM    events
		WHERE	events.id = eventID;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `role_link_acquire`(IN hash varchar(32), IN userID INT(5))
BEGIN
	IF (SELECT COUNT(role_links.id) FROM role_links WHERE role_links.hash = hash) = 0 THEN
		SELECT 3002 as errc;
	ELSE
		SELECT 	role_links.eventid,
				role_links.role_set,
                roles.name,
                events.name
		INTO	@eventid,
				@role,
                @roleName,
                @eventName
		FROM	role_links
	LEFT JOIN 	roles
		ON 		roles.id = role_links.role_set
    LEFT JOIN 	events
		ON 		events.id = role_links.eventid
        WHERE	role_links.hash = hash;
		IF (SELECT COUNT(roles_binds.id) FROM roles_binds WHERE roles_binds.userid = userID AND roles_binds.role = @role AND roles_binds.eventid = @eventid) > 0 THEN
			SELECT 3003 as errc, @role as role, @eventid as eventid;
		ELSEIF (SELECT COUNT(roles_binds.id) FROM roles_binds WHERE roles_binds.userid = userID  AND roles_binds.eventid = @eventid) > 0 THEN
			UPDATE 	`roles_binds`
				SET		roles_binds.role = @role
				WHERE	roles_binds.userid = userID 
                AND 	roles_binds.eventid = @eventid;
			SELECT 0 as errc, @roleName as roleName, @eventName as eventName;
		ELSE
			INSERT INTO roles_binds(
				`userid`,`role`,`eventid`
			) 
			VALUES (	
				userID,@role,@eventid
			);
			SELECT 0 as errc, @role as role, @eventid as eventid, @roleName as roleName, @eventName as eventName;
		END IF;
    END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `event_create`(IN name CHAR(32),IN points INT(5),IN dtStart CHAR(16),IN dtEnd CHAR(16))
BEGIN
	SET @hash = md5(concat(LAST_INSERT_ID(),name,points,'FNRMmPZqSggS'));
	INSERT INTO 	events
					(
						`name`, `hash`, `points`,`dtStart`, `dtEnd`
					) 
	VALUES 			(	
						name, @hash, points,dtStart, dtEnd
					);
	SELECT 0 AS errc, LAST_INSERT_ID() as id, @hash as hash;	
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `role_link_create`(IN eventID INT(5), IN role_set INT(5))
BEGIN
	IF (SELECT COUNT(role_links.id) FROM role_links WHERE role_links.eventid = eventID AND role_links.role_set = role_set) > 0 THEN
		-- SET @message_text = CONCAT('User \'', name, '\' already exists');
		-- SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text;
        SELECT 3001 as errc;
	ELSE
		SET @hash = md5(concat(LAST_INSERT_ID(),eventID,role_set,'Mpx6d32vQA'));
		INSERT INTO role_links(
			`hash`,`role_set`,`eventid`
		) 
        VALUES (	
			@hash,role_set,eventID
		);
		SELECT 0 as errc, @hash as hash;
	END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `role_link_list`(IN eventID INT(5))
BEGIN
	SELECT 	role_links.id as id,
			role_links.role_set as role,
            role_links.hash as link,
            roles.name as roleName
	FROM	role_links
LEFT JOIN 	roles
	ON 		roles.id = role_links.role_set
	WHERE	role_links.eventid = eventID;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `settings_get`(IN `keyName` CHAR(32))
BEGIN
	if (keyName = 'inst') THEN 
			SELECT 	id,
					name
			FROM	institutes;
	END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `user_auth`(IN `login` CHAR(32), IN `pass` CHAR(64))
BEGIN
	IF (SELECT COUNT(users.id) FROM users WHERE (users.login = login OR users.email = login) AND users.password = pass) != 1 THEN
		-- SET @message_text = CONCAT('Login incorrect for user \'', @name, '\'');
		-- SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text;
        SELECT 1002 as errc, 0 as id, login, '' as email,  0 as isAdmin;
	ELSE
		SELECT 		0 as errc,
					users.id as id, 
					users.login as login, 
					users.name as name, 
					users.avatarID as avatarID, 
					users.email as email,
					users.isAdmin as isAdmin,
					(SELECT SUM(checkins.points) FROM  checkins WHERE checkins.userid = users.id) as points,
                    users.instituteID as instituteID,
					inst.name as instituteName
		FROM 		users 
        
        LEFT JOIN	institutes inst
		ON			inst.id = users.instituteID
        
		WHERE 		users.login = login 
        OR 			users.email = login;
		
	END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `user_avatar_set`(IN userID INT(5), IN avatarID CHAR(32))
BEGIN
	UPDATE 	`users`
		SET		users.avatarID = avatarID
		WHERE	users.id = userID;
	SELECT 0 AS errc;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `user_create`(IN `login` CHAR(32), IN `name` CHAR(64), IN `email` CHAR(64), IN `password` CHAR(64), IN `instituteID` INT(5))
BEGIN
	-- $login, $name, $email, $password
	IF (SELECT COUNT(users.id) FROM users WHERE users.login = login OR users.email = email) > 0 THEN
		-- SET @message_text = CONCAT('User \'', name, '\' already exists');
		-- SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text;
        SELECT 1004 as errc;
	ELSE
		INSERT INTO users(
			`login`, `email`, `password`, `name`,`instituteID`
		) 
        VALUES (	
			login, email, password, name, instituteID
		);
		SELECT 0 as errc;
	END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `user_edit`(IN userID INT(5), IN `password` CHAR(64), IN `name` CHAR(64), IN `email` CHAR(64), IN `instituteID` CHAR(64))
BEGIN
	IF (SELECT COUNT(users.id) FROM users WHERE users.id = userID) > 0 THEN
		UPDATE	users
        SET		users.name = name,
				users.email = email,
                users.password = password,
                users.instituteID = instituteID
		WHERE	users.id = userID;
        SELECT 0 as errc;
	ELSE
		SELECT 1001 as errc;
	END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `user_points_get`(IN userID INT(5))
BEGIN
	SELECT SUM(checkins.points) as points FROM  checkins WHERE checkins.userid = userID;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `user_points_history`(IN userID INT(5))
BEGIN
	 SELECT 		checkins.points,
					checkins.dtAdded as date,
					events.name as eventName,
                    IFNULL(binds.role,0) as role,
					IFNULL(roles.name,'Участник') as roleName
	FROM 			checkins
	LEFT JOIN		events
	ON				events.id = checkins.eventid
    
    LEFT JOIN	roles_binds binds
	ON			binds.userid = userID
    AND			binds.eventid = events.id
    
	LEFT JOIN	roles
	ON			roles.id = binds.role
    
	WHERE			checkins.userid = userID
    order by		date DESC;
END$$
DELIMITER ;
