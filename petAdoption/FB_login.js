   
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "https://connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.10&appId=384016991980564";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
    
    
  window.fbAsyncInit = function() {
  FB.init({
    appId      : '{384016991980564}',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.8' // use graph api version 2.8
  });
    
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };
    
function getLoginStatus(){
    
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
    
}

    
function statusChangeCallback(response) {

    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      loginStatus = true;
      testAPI();
    } else {
      // The person is not logged into your app or we are unable to tell.
      loginStatus = false;
      userID = '';
      userCollection = [];
      loadUserCollectionFromAPI();
      document.getElementById('status').innerHTML = '您尚未登入!!';
    }
  }
    
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('me?fields=id,name,picture', function(response) {     //"me?"後面可以設定response回傳資料要有哪些種類
      console.log('Successful login for: ' + response.name);
        
    userID = response.id;   
    console.log("user id :"+userID);
    $.post('/load_user_collection.php',{user_id:userID},function(data,status){
        if(status == 'success'){
            userCollection = JSON.parse(data);
            loadUserCollectionFromAPI();
        }
        console.log(status);
    });  
    
      document.getElementById('status').innerHTML =
          '<img width="40" height="40" src="http://graph.facebook.com/'+response.id+'/picture?type=large">'
    });
  }
    