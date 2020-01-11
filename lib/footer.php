        </div> <!-- end container -->
    </div> <!-- end wrapper -->
        

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        &copy; Copyright <?php echo date("Y"); ?> by <strong>SS88 GROUP</strong>
                    </div>
                </div>
            </div>
        </footer>
        <!-- End Footer -->
        
    <script type="text/javascript">
        function detail_order(url) {
        	$.ajax({
        		type: "GET",
        		url: url,
        		beforeSend: function() {
        			$('#modal-detail-body').html('Sedang memuat...');
        		},
        		success: function(result) {
        			$('#modal-detail-body').html(result);
        		},
        		error: function() {
        			$('#modal-detail-body').html('Terjadi kesalahan.');
        		}
        	});
        	$('#modal-detail').modal();
        }
    </script>
    
    <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    	<div class="modal-dialog modal-dialog-centered modal-lg">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    				<h4 class="modal-title text-center"><i class="fa fa-search fa-fw"></i> Detail Data</h4>
    			</div>
    			<div class="modal-body" id="modal-detail-body">
    			</div>
    			<div class="modal-footer">
    				<button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
    			</div>
    		</div>
    	</div>
    </div>

        <script src="http://localhost/tokol/assets1/js/jquery.core.js"></script>
	    <script src="http://localhost/tokol/assets1/js/jquery.app.js"></script>
        <script src="<http://localhost/tokol/assets1/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="http://localhost/tokol/assets1/plugins/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="http://localhost/tokol/assets1/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="http://localhost/tokol/assets1/plugins/datatables/responsive.bootstrap4.min.js"></script>
    
        <script>
          $(function () {
            $('#example1').DataTable()
            $('#example2').DataTable({
              'paging'      : true,
              'lengthChange': false,
              'searching'   : false,
              'ordering'    : false,
              'info'        : true,
              'autoWidth'   : false
            })
          })
        </script>
</body>
</html>