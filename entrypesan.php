<?php 
require_once 'functions.php';


?>

<?= startHTML('Entry Pesan'); ?>

<div class="container">
	<!-- Button trigger modal -->
	<button type="button" class="btn btn-success mt-4" data-toggle="modal" data-target="#exampleModal">
	  Tambah Data
	</button>
	<table class="table mt-3">
		  <thead class="table-success">
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Kode Jasa</th>
		      <th scope="col">Nama Jasa</th>
		      <th scope="col">Lama Jasa</th>
		      <th scope="col">Jumlah Pesan</th>
		      <th scope="col">Harga Pesan</th>
		      <th scope="col">Jumlah Harga</th>
		    </tr>
		  </thead>
		  <tbody>
		   
		 </tbody>
	</table>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?= endHTML(); ?>