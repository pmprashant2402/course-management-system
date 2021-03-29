<div id="studentModal" class="modal fade">
      <div class="modal-dialog">
        <form method="post" id="registration" name="registration">
          <div class="modal-content">
            <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal">&times;</button>
        	<h4 class="modal-title"><i class="fa fa-plus"></i> Edit User</h4>
            </div>
            <div class="modal-body">
            <div class="form-group"
              <label for="name" class="control-label">First Name</label>
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required>      
            </div>
            <div class="form-group">
              <label for="age" class="control-label">Last Name</label>              
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">              
            </div>      
            <div class="form-group">
              <label for="lastname" class="control-label">Email</label>              
              <input type="email" class="form-control"  id="email" name="email" placeholder="email" required>             
            </div>   
            <div class="form-group">
              <label for="date" class="control-label">Date of birth</label>              
              <input type="date" placeholder="yyyy-mm-dd" class="form-control"  id="date_of_birth" name="date_of_birth" required>           
            </div>
            <div class="form-group">
              <label for="lastname" class="control-label">Contact Number</label>             
              <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Contact Number">      
            </div>            
            </div>
            <div class="modal-footer">
              <input type="hidden" name="studentId" id="studentId" />
              <input type="hidden" name="action" id="action" value="" />
              <input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
              <button type="button" class="btn btn-info hide update_student_records" value="">Save</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>