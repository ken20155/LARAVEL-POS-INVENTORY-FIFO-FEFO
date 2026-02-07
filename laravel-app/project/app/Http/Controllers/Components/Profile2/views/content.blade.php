<style>
    .image-container {
      position: relative;
    }
    .image-container::after {
      content: "Upload Image";
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
      background-color: rgba(0, 0, 0, 0.5);
      padding: 10px;
      display: none;
      cursor: pointer;
      z-index: 1;
    }
    .image-container:hover::after {
      display: block;
    }
    .image-upload-btn {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      opacity: 0;
      cursor: pointer;
      z-index: 2;
    }
    .uploaded-image {
      /* display: none; */
      max-width: 100%;
      max-height: 100%;
    }
    .fixed-height{
        height:200px;
    }
    </style>
    <style>
        .form-control-lg{
            min-height: calc(1.5em + (1rem + 2px));
        padding: .5rem 1rem;
        font-size: 1.25rem;
        border-radius: .3rem;
        }
    </style>
<div id="html-form"></div>