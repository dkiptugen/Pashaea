<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Developed by :</b> <a href='http://www.caydeesoft.org' target="_blank">CAYDEESOFT SOLUTIONS LTD</a>
    </div>
    <strong>Copyright &copy; 2017 <a href="http://www.pashaEa.com" target="_blank">Pasha EA.</a></strong> All rights reserved.
</footer>


</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="<?=base_url("cms-assets/plugins/jQuery/jQuery-2.1.4.min.js"); ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.5 -->
<script src="<?=base_url("cms-assets/bootstrap/js/bootstrap.min.js"); ?>"></script>

<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="<?=base_url("cms-assets/plugins/daterangepicker/daterangepicker.js"); ?>"></script>
<!-- datepicker -->
<script src="<?=base_url("cms-assets/plugins/datepicker/bootstrap-datepicker.js");?>"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?=base_url("cms-assets/plugins/summernote/summernote.js"); ?>"></script>
<!-- Slimscroll -->
<script src="<?=base_url("cms-assets/plugins/slimScroll/jquery.slimscroll.min.js"); ?>"></script>
<!-- FastClick -->
<script src="<?=base_url("cms-assets/plugins/fastclick/fastclick.min.js"); ?>"></script>
<!-- AdminLTE App -->
<script src="<?=base_url("cms-assets/dist/js/app.min.js"); ?>"></script>
<script>
$(document).ready(function() {
    var IMAGE_PATH = '<?=base_url()."uploads/"; ?>';
    var UPLOAD_LINK='<?=site_url('cms/picuploads'); ?>';
    $('.summernote').summernote({
            height: 200,
            toolbar: [
                        // [groupName, [list of button]]
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript','fontname']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph','style']],
                        ['height', ['height']],
                        ['insert',['picture','link','video','table','hr']],
                        ['misc',['codeview','undo','redo']]
                      ],
            callbacks : {
                          onImageUpload: function(image) {
                                                            uploadImage(image[0]);

                                                         }
                        }           
        });
     function uploadImage(image) {
            console.log(image);
        var dat = new FormData();
        dat.append("image",image);

        $.ajax ({
            data: dat,
            type: "POST",
            url: UPLOAD_LINK,
            cache: false,
            contentType: false,
            processData: false,
            success: function(url) {
                var image = IMAGE_PATH + url;
                $('.summernote').summernote("insertImage", image);
                },
                error: function(data) {
                    console.log(data);
                    }
            });
        }
    });
</script>

</body>
</html>