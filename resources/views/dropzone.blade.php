<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Drag and Drop with preview image in vanilla javascript by AppleRinquest.com</title>

	<style>
		@charset "UTF-8";
.form {
  width: 500px;
  margin: 5% auto;
}
.form__container {
  position: relative;
  width: 100%;
  height: 200px;
  border: 2px dashed silver;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 18px;
  color: silver;
  margin-bottom: 5px;
}
.form__container.active {
  background-color: rgba(192, 192, 192, 0.2);
}
.form__file {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  cursor: pointer;
  opacity: 0;
}
.form__files-container {
  display: block;
  width: 100%;
  font-size: 0;
  margin-top: 20px;
}
.form__image-container {
  display: inline-block;
  width: 49%;
  height: 200px;
  margin-bottom: 10px;
  position: relative;
}
.form__image-container:not(:nth-child(2n)) {
  margin-right: 2%;
}
.form__image-container:after {
  content: "✕";
  position: absolute;
  line-height: 200px;
  font-size: 30px;
  margin: auto;
  top: 0;
  right: 0;
  left: 0;
  text-align: center;
  font-weight: bold;
  color: #fff;
  background-color: rgba(0, 0, 0, 0.4);
  opacity: 0;
  transition: opacity 0.2s ease-in-out;
}
.form__image-container:hover:after {
  opacity: 1;
  cursor: pointer;
}
.form__image {
  -o-object-fit: contain;
     object-fit: contain;
  width: 100%;
  height: 100%;
}
	</style>
</head>
<body>

    <!-- 
        NOTE: 
        The code based can use for the multiple uploaded image inputs. 
        Each uploaded image input will have its own preview image card. 
        In this code, 

        We refer the elements by classname in Javascript. We don't use the element Id.
    -->

    <!-- Title -->
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form class="form">
					<label class="form__container" id="upload-container">Choose or Drag & Drop Files
					  <input class="form__file" id="upload-files" type="file" accept="image/*" multiple="multiple"/>
					</label>
					<div class="form__files-container" id="files-list-container"></div>
				  </form>
            </div>
        </div>   
    </div>
<script>
	const INPUT_FILE = document.querySelector('#upload-files');
const INPUT_CONTAINER = document.querySelector('#upload-container');
const FILES_LIST_CONTAINER = document.querySelector('#files-list-container');
const FILE_LIST = [];
let UPLOADED_FILES = [];

const multipleEvents = (element, eventNames, listener) => {
  const events = eventNames.split(' ');

  events.forEach(event => {
    element.addEventListener(event, listener, false);
  });
};

const previewImages = () => {
  FILES_LIST_CONTAINER.innerHTML = '';
  if (FILE_LIST.length > 0) {
    FILE_LIST.forEach((addedFile, index) => {
      const content = `
        <div class="form__image-container js-remove-image" data-index="${index}">
          <img class="form__image" src="${addedFile.url}" alt="${addedFile.name}">
        </div>
      `;

      FILES_LIST_CONTAINER.insertAdjacentHTML('beforeEnd', content);
    });
  } else {
    console.log('empty');
    INPUT_FILE.value = "";
  }
};

const fileUpload = () => {
  if (FILES_LIST_CONTAINER) {
    multipleEvents(INPUT_FILE, 'click dragstart dragover', () => {
      INPUT_CONTAINER.classList.add('active');
    });

    multipleEvents(INPUT_FILE, 'dragleave dragend drop change blur', () => {
      INPUT_CONTAINER.classList.remove('active');
    });

    INPUT_FILE.addEventListener('change', () => {
      const files = [...INPUT_FILE.files];
      console.log("changed");
      files.forEach(file => {
        const fileURL = URL.createObjectURL(file);
        const fileName = file.name;
        if (!file.type.match("image/")) {
          alert(file.name + " is not an image");
          console.log(file.type);
        } else {
          const uploadedFiles = {
            name: fileName,
            url: fileURL };


          FILE_LIST.push(uploadedFiles);
        }
      });

      console.log(FILE_LIST); //final list of uploaded files
      previewImages();
      UPLOADED_FILES = document.querySelectorAll(".js-remove-image");
      removeFile();
    });
  }
};

const removeFile = () => {
  UPLOADED_FILES = document.querySelectorAll(".js-remove-image");

  if (UPLOADED_FILES) {
    UPLOADED_FILES.forEach(image => {
      image.addEventListener('click', function () {
        const fileIndex = this.getAttribute('data-index');

        FILE_LIST.splice(fileIndex, 1);
        previewImages();
        removeFile();
      });
    });
  } else {
    [...INPUT_FILE.files] = [];
  }
};

fileUpload();
removeFile();
</script>
</body>
</html>