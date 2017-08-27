<h3><?= $page_title ?></h3>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php
$attributes = array('name' => 'myform');
echo form_open_multipart('admin/c_kontak_perangkat/simpan_kontak_perangkat', $attributes); 
?>
<fieldset>
<legend></legend>
	<div class="form-group"> 	
    	 <label class="col-md-3 control-label" for="nama_perangkat">Nama Perangkat</label>
        <div class="col-md-9">
         <span class="help-block">
			<input class="form-control input-md"  type="text" name="nama_perangkat" id="nama_perangkat" placeholder="Nama Perangkat" required/>
			<?php echo form_error('nama_perangkat', '<p class="field_error">','</p>')?>	
		</span>
		</div>
	</div>
	<legend></legend>
	<div class="form-group">
    	 <label  class="col-md-3 control-label" for="jabatan_perangkat">Jabatan</label> 
        <div class="col-md-9">
         <?php $options = array(
						''=>'-- Pilih --',
						'Kepala Desa' => 'Kepala Desa',
						'Sekertaris Desa' => 'Sekertaris Desa',
						'Kaur Pemerintahan' => 'Kaur Pemerintahan',
						'Kaur Pembangunan' => 'Kaur Pembangunan',
						'Kaur Kesra' => 'Kaur Kesra',
						'Kaur Keuangan' => 'Kaur Keuangan',
						'Kaur Umum' => 'Kaur Umum',
						);
					$id = 'id="jabatan_perangkat" class="form-control input-md" required';
				echo form_dropdown('jabatan_perangkat',$options,'',$id); ?>
        
         <span class="help-block">
		<?php echo form_error('jabatan_perangkat', '<p class="field_error">','</p>')?>
        </span>
        </div>
	</div>
	<legend></legend>
	<div class="form-group"> 	
    	 <label class="col-md-3 control-label" for="nohp_perangkat">No. HP Perangkat</label>
        <div class="col-md-9">
         <span class="help-block">
			<input class="form-control input-md"  type="text" name="nohp_perangkat" id="nohp_perangkat" placeholder="No. HP Perangkat" required/>
			<?php echo form_error('nohp_perangkat', '<p class="field_error">','</p>')?>	
		</span>
		</div>
	</div>
	<legend></legend>
	<div class="form-group"> 	
    	 <label class="col-md-3 control-label" for="alamat_perangkat">Alamat Perangkat</label>
        <div class="col-md-9">
         <span class="help-block">
			<input class="form-control input-md"  type="text" name="alamat_perangkat" id="alamat_perangkat" placeholder="Alamat Perangkat" required/>
			<?php echo form_error('alamat_perangkat', '<p class="field_error">','</p>')?>	
		</span>
		</div>
	</div>
	<legend></legend>
	<div class="form-group"> 	
    	 <label class="col-md-3 control-label" for="foto_perangkat">Foto Perangkat</label>
        <div class="col-md-9">
         <span class="help-block">
			<input class="form-control input-md"  type="file" name="foto_perangkat" id="imgInp1" multiple >
			<div align="right">Gambar harus bertipe .jpg atau .jpeg</div>
		</span>
		</div>
		<label class="col-md-3 control-label"></label>
		 <div class="col-md-3">
			<img id="blah1" src="#" alt="your image"  class='img-responsive img-thumbnail' width="150px" height="150px"/><br><br>
		</div>
	</div>	
<legend></legend>

<p>
<input type="submit" class="btn btn-success" value="Simpan" id="simpan"/>
<input type="button" class="btn btn-danger" value="Batal" id="batal" onclick="location.href='<?= base_url() ?>admin/c_kontak_perangkat'"/>
</p>

</fieldset>
<br>
<?php echo form_close(); ?>

<script>

function readURL_logoDesa(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }
		
        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function(){
    readURL_logoDesa(this);
	{document.getElementById("blah").style.display = 'block';}
});

$( document ).ready(function() {
   {document.getElementById("blah").style.display = 'none';}
});

function readURL_logoKabupaten(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah1').attr('src', e.target.result);
        }
		
        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp1").change(function(){
    readURL_logoKabupaten(this);
	{document.getElementById("blah1").style.display = 'block';}
});

$( document ).ready(function() {
   {document.getElementById("blah1").style.display = 'none';}
});

function nav_active(){

	document.getElementById("a-data-web").className = "collapsed active";
	
	var r = document.getElementById("pengelola_data_web");
	r.className = "collapsed";

	var d = document.getElementById("nav-contact");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>