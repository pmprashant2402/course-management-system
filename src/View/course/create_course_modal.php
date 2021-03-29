<div id="courseModal" class="modal fade">
      <div class="modal-dialog">
        <form method="post" id="create_course" name="create_course">
          <div class="modal-content">
            <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal">&times;</button>
        	<h4 class="modal-title"><i class="fa fa-plus"></i> Edit Course</h4>
            </div>
            <div class="modal-body">
            <div class="form-group"
              <label for="name" class="control-label"> Name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>      
            </div>
            <div class="form-group">
              <label for="age" class="control-label">Details</label>              
              <input type="text" class="form-control" id="details" name="details" placeholder="Details">              
            </div>      
            </div>
            <div class="modal-footer">
              <input type="hidden" name="courseId" id="courseId" />
              <input type="hidden" name="action" id="action" value="" />
              <input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
              <button type="button" class="btn btn-info hide update_course_records" value="">Save</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>