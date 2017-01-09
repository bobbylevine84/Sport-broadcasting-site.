
<div class="inner-content">
    <div class="container">
        <div class="form-bg" style="padding: 0px;">
            <h1>Please add your Gamer tags</h1>
            <form style="padding: 10px;" id="console_form" method="POST" action="<?php echo base_url(); ?>profile/consoles" role="form" class="form-inline">
                <div id="dynamicInput">
                    <div class="form-group" style="padding-left: 10px;">
                        <label for="consoles">Consoles :</label>
                        <select id="consoles" name="consoles[]" required="required" class="form-control">
                            <?php
                            foreach ($consoles as $console) {
                                ?>
                                <option value="<?php echo $console['id']; ?>"><?php echo ucwords($console['name']); ?></option>
                            <?php } ?> 
                        </select>
                    </div>
                    <div class="form-group" style="padding-left: 10px;">
                        <label for="consoles">Gamer Tag :</label>
                        <input id="tags" type="text" required="required" class="form-control" placeholder="Enter Your Gamer Tag" name="tags[]" style="width: 200px;">
                    </div>
                </div> 
                <div class="form-group" style="margin-left: 247px; margin-top: 30px;">                    
                    <input type="button" class="btn btn-info" value="Add More" onClick="addInput('dynamicInput');">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="<?php echo base_url(); ?>home/dashboard" class="btn btn-primary">Add Later</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!--<script src="<?php //echo base_url();  ?>assets/plugins/jQuery-lib/2.0.3/jquery.min.js"></script>
<script src="<?php //echo base_url();  ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script> -->
<!--        <script src="<?php //echo base_url();  ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
    <script src="<?php //echo base_url();  ?>assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>-->
<script>
    function addInput(divName)
    {
        var newdiv = document.createElement('div');
        newdiv.innerHTML =
                "</br>" +
                "<div class='form-group' style='padding-left: 10px;'> <label for='consoles'>Consoles : </label> " +
                "<select name='consoles[]' required='required' class='form-control'><?php foreach ($consoles as $console) { ?><option value='<?php echo $console['id']; ?>'><?php echo ucwords($console['name']); ?></option><?php } ?></select></div>" +
                "<div class='form-group' style='padding-left: 10px;'> <label for='gamertags'>Gamer Tag : </label> " +
                "<input type='text' required='required' placeholder='Enter Your Gamer Tag' class='form-control' name='tags[]' style='width:200px;'>";
        document.getElementById(divName).appendChild(newdiv);
    }



</script>
<script>
    var $jq = jQuery.noConflict();
    $jq(document).ready(function ()
    {
        $jq("#console_form").validate({
            rules:
                    {
                        consoles:
                                {
                                    required: true
                                },
                        tags:
                                {
                                    required: true
                                }
                    }

        });
    });//document.ready
</script>
<?php $this->load->view('includes/footer_after_login'); ?>