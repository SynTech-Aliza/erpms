function triggerClickProfileImage(e) {
        document.querySelector('#idSelect').click();
    }
    function displayProfileImage(e) {
      if (e.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e){
          document.querySelector('#idPicture').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
      }
    }

function triggerClickProfileImages(e) {
        document.querySelector('#personSelect').click();
    }
    function displayProfileImages(e) {
      if (e.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e){
          document.querySelector('#personProfile').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
      }
    }