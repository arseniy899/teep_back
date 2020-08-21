<?
if(False /*strstr(REQUESTED_PATH,"portal")*/)
{
?>

<!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.2.1/firebase-app.js"></script>

<!-- If you enabled Analytics in your project, add the Firebase SDK for Analytics -->
<script src="https://www.gstatic.com/firebasejs/7.2.1/firebase-analytics.js"></script>

<!-- Add Firebase products that you want to use -->
<script src="https://www.gstatic.com/firebasejs/7.2.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.2.1/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.2.1/firebase-messaging.js"></script>
<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->

<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyBQye72OLn9NaPaTYIWJ00OiAnuw943Nz8",
    authDomain: "smarthouse-o.firebaseapp.com",
    databaseURL: "https://smarthouse-o.firebaseio.com",
    projectId: "smarthouse-o",
    storageBucket: "smarthouse-o.appspot.com",
    messagingSenderId: "246944254798",
    appId: "1:246944254798:web:92b0f14c2baabc27752c1f"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
</script>
<script src="//<?=REMOTE_ROOT?>/js/notifications.js?q=1" lazyload></script>
<?}?>
<!--<script type="text/javascript">
	(function() {
		var css = document.createElement('link');
		//css.href = '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css';
		css.href = 'https://fonts.googleapis.com/icon?family=Material+Icons';
		css.rel = 'stylesheet';
		css.type = 'text/css';
		document.getElementsByTagName('head')[0].appendChild(css);
	})();
</script>-->