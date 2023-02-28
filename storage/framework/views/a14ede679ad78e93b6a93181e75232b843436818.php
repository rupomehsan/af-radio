<div class="modal-content">
    <div class="modal-title">
        <h4>Add Station</h4>
    </div>
    <form id="countryCreateForm" method="POST" enctype="multipart/form-data">
        <div class="form-group margin-top-40">
            <input name="name" type="text" class="form-control create-form" id="autoComplete" placeholder="Station Name">
        </div>

        <div class="file-upload">
            <div class="image-upload-wrap">
                <input type="hidden" name="image" id="imageUrl">
                <input id="image" class="file-upload-input file-uploader" type='file' onchange="readURL(this);"
                       accept="image/*" />
                <div class="drag-text text-center">
                    <span class="iconify" data-icon="teenyicons:user-square-outline"></span> <br>
                    <span>Upload Image Or Drag Here</span>
                </div>
            </div>
            <div class="file-upload-content">
                <img class="file-upload-image" src="#" alt="your image" />
                <div class="image-title-wrap">
                    <button type="button" onclick="removeUpload()" class="remove-image">
                        <span class="iconify" data-icon="akar-icons:cross"></span>
                    </button>
                </div>
            </div>
        </div>

        <div class="actions margin-top-40">
            <button class="submit" type="submit" id="createCountry">Add Station</button>
            <button type="button" class="cancel" data-dismiss="modal">Cancel</button>
        </div>
    </form>

</div>
<script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.6/dist/autoComplete.min.js"></script>
    <script>
        const autoCompleteJS = new autoComplete({
            placeHolder: "Search for Station...",
            data: {
               src: [],
               cache: true,
            },
            resultItem: {
                highlight: true
            },
            events: {
                input: {
                    selection: (event) => {
                        const selection = event.detail.selection.value;
                        autoCompleteJS.input.value = selection;
                    }
                }
            }
        });
    </script>
<?php /**PATH /home/tausif/Desktop/rupom/mainProject/af_radio/resources/views/country/create.blade.php ENDPATH**/ ?>