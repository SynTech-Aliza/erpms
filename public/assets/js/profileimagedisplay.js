function triggerClickProfileImage(e) {
        document.querySelector('#UserProfile').click();
    }
    function displayProfileImage(e) {
      if (e.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e){
          document.querySelector('#UserProfileDisplay').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
      }
    }