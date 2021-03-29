<div id="assignModal" class="modal fade">
      <div class="modal-dialog">
        <form method="post" id="assign_course" name="assign_course">
          <div class="modal-content">
            <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal">&times;</button>
        	<h4 class="modal-title"><i class="fa fa-plus"></i> Edit Course</h4>
            </div>
            <div class="modal-body">
          	<div class="table-repsonsive">
		     <span id="error"></span>
		     <table class="table table-bordered" id="item_table">
		      <tr>
		       <th>Select Student</th>
		       <th>Select Course</th>
		       <th><button type="button"  name="add" class="btn btn-success btn-sm assign_course"><span class="glyphicon glyphicon-plus"></span></button></th>
		      </tr>
		     </table>
		    </div>    
            </div>
            <div class="modal-footer">
              <input type="hidden" name="assignedId" id="assignedId" />
              <input type="hidden" name="action" id="action" value="" />
              <input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
              <button type="button" class="btn btn-info hide update_assigned_course" value="">Save</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>