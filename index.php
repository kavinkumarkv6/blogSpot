<?php include( "layout/header.php" ); ?>
<section class="section">
    <div class="section-body">
      	<div class="row">
        	<div class="col-12 col-md-12 col-lg-12">
        		<div class="card">
        			<div class="card-header">
        				<div class="row w-100">
                    <div class="col-md-2">
                      <h4>Dashboard</h4>
                    </div>    
                    <div class="col-md-8">&nbsp;</div>
                    <div class="col-md-2">
                        <a href="add_blog">
                            <button class="btn btn-primary">Add Blog</button>
                        </a>
                    </div>
                </div>
        			</div>
              <div class="container">
                  <div class="row">
                      <div class="col-md-2">
                        <select id="numberofpages" class="form-control">
                            <option value="<?php echo $crud->item_per_page;?>" selected> 
                              <?php echo $crud->item_per_page; ?>
                            </option>
                            <option value="10" >10</option>
                            <option value="20"> 20</option>
                            <option value="50"> 50</option>
                            <option value="100"> 100</option>
                        </select>
                      </div>
                      <div class="col-md-7">&nbsp;</div>
                      <div class="col-md-3">
                        <input type="text" id="search" class="form-control infield-bordered">
                      </div>
                  </div>
              </div>
              <div class="loading-div">
                  <img src="assets/img/loading.gif">
              </div>
        			<div class="card-body" id="response">

        			</div>
        		</div>
      		</div>
      	</div>
	</div>
</section>
<?php include( "layout/footer.php" ); ?>
<script type="text/javascript">
  $(document).ready(function(){
        $("#response").load( "fetch_blog", { "numberofpages": $("#numberofpages").val() }); 
        $("#response").on( "click", ".pagination a", function (e){
            e.preventDefault();
            $(".loading-div").show();
            var page = $(this).attr("data-page");
            $("#response").load("fetch_blog",{"page":page, "numberofpages":$("#numberofpages").val() }, function(){ 
                $(".loading-div").hide();
            });
        });
        $("#numberofpages").on( "change", function(){
            $(".loading-div").show();
            $("#response").load("fetch_blog",{ "numberofpages": $("#numberofpages").val() });
          $(".loading-div").hide();
        });
        $( "#search" ).on( "keyup",function(e){
          e.preventDefault();
            $(".loading-div").show();
          var value = $(this).val();
          $("#response").load("fetch_blog",{ 
              "numberofpages": $("#numberofpages").val(),
              "search_val":value 
            });
          $(".loading-div").hide();   
        });
  });
</script>