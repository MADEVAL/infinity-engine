
<div style="width: 70%; display: block; margin:auto;">

    <h5 style="text-align: center; font-weight: bolder;">
        New Board
    </h5>

    <form method="post">
        <div class="adminForm row">
            <div class="inputGroup">
                <div class="col s3 formLabel">
                    Title
                </div>
                <div class="col s8">
                    <input name="board_title" type="text" />
                </div>
            </div>
            <div class="inputGroup">
                <div class="col s3 formLabel">
                    Description
                </div>
                <div class="col s8">
                    <input name="board_desc" type="text" />
                </div>
            </div>
            <div class="inputGroup">
                <div class="col s3 formLabel">
                    Color
                </div>
                <div class="col s8">
                <select name="board_color">
                    <option value="purple" disabled>Choose List Color</option>
                    <option value="purple">Purple</option>
                    <option value="blue">Blue</option>
                    <option value="pink">Pink</option>
                </select>
                </div>
            </div>
            <div class="inputGroup">
                <div class="col s3 formLabel">
                    Pill Color
                </div>
                <div class="col s8">
                <select name="board_background">
                    <option value="purple" disabled>Choose List Color</option>
                    <option value="purple">Purple</option>
                    <option value="blue">Blue</option>
                    <option value="pink">Pink</option>
                </select>
                </div>
            </div>
            

            <div class="btnGroup">
                <div class="col s3"></div>
                <div class="col s5" style="text-align: center;">
                    <input name="board_new" class="btn btn-block waves-block color-purple waves-effect waves-light" type="submit" value="Create" style="margin:0; margin-bottom:25px;" />
                </div>
            </div>

        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    $('select').material_select();
});
</script>