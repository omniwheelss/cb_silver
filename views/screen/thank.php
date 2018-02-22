        <!-- page content -->
        <div class="col-md-12">
          <div class="col-middle">
            <div class="text-center text-center">
              <h1 class="thank-message">Thank You !!!!</h1>
              <!--<h2>You have successfully submitted the data. </h2>-->
				<?php
					// error Message print from request method	
					if (isset($_REQUEST['msg'])) {
					
						$this->message = $_REQUEST['msg'];
						$mt = $_REQUEST['mt'];
						if (isset($this->message) && !empty($this->message) ) {
					  ?>
						<div class="alert alert-<?=$mt?> alert-dismissible fade in" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
						  </button>
						  <?=$this->message?>
						</div>		
						<?php
						}
					}
				?>
				<p>Go to <a href="index.php?do=home">Home</a></p>

			  <!--
              <div class="mid_center">
                <h3>Search</h3>
                <form>
                  <div class="col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Search for...">
                      <span class="input-group-btn">
                              <button class="btn btn-default" type="button">Go!</button>
                          </span>
                    </div>
                  </div>
                </form>
              </div>
			  -->
            </div>
          </div>
        </div>
        <!-- /page content -->
