function triggerClickProfileImages(e) {
        document.querySelector('#profileSelect').click();
    }
    function displayProfileImages(e) {
      if (e.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e){
          document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
      }
    }

    // ID Attachment
    function triggerClickProfileImage(e) {
        document.querySelector('#IDSelect').click();
    }
    function displayProfileImage(e) {
      if (e.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e){
          document.querySelector('#IDDisplay').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
      }
    }