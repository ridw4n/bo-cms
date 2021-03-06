<section class="content-header">
	<h1><?php echo $title;?></h1>
</section>
<section class="content-header aksi">
	<?php echo anchor('menu/admin', 'Kembali');?>
</section>

<section class="content">
    <?php echo form_open($action);?>
    
    <input type="hidden" name="id_menu" value="<?php echo $id_menu; ?>" />
    
    <div class="row">
        <div class="col-xs-12">
            <label for="name" class="control-label">Nama Menu</label>
            <input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>" />
            <p><?php echo form_error('name') ?></p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-12">
            <label for="link" class="control-label">Link Menu</label>
            <input type="text" class="form-control" name="link" id="link" value="<?php echo $link; ?>" />
            <p><?php echo form_error('link') ?></p>
        </div>
    </div>
	
	<div class="row">
        <div class="col-xs-12">
            <label for="is_parent" class="control-label">Is Parent</label>
            <select name="is_parent" class="form-control is_parent" id="is_parent">
                <option value="0">YA</option>
                <?php
                $menu = $this->db->get('menu_admin');
                foreach ($menu->result() as $m){
                echo "<option value='$m->id_menu' ";
                    echo $m->id_menu==$is_parent?'selected':'';
                echo">".  strtoupper($m->name)."</option>";
                }
                ?>
            </select>
            <p><?php echo form_error('is_parent') ?></p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-12">
            <label for="icon" class="control-label">Icon</label>
			<div class="input-group">
				<span class="input-group-addon show-icon" id="basic-addon1">&nbsp</span>
				<input type="text" class="form-control icon" id="icon" name="icon" value="<?php echo $icon ?>">
			</div>
            <p><?php echo form_error('icon') ?></p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-6">
            <label for="is_active" class="control-label">Status</label>
            <?php 
                echo form_dropdown('is_active', array('1'=>'AKTIF','0'=>'TIDAK AKTIF'), $is_active, "class='form-control is_active' id='is_active'");
            ?>
            <p><?php echo form_error('is_active') ?></p>
        </div>
        <div class="col-sm-6">
            <label for="order" class="control-label">Urutan</label>
            <input type="text" class="form-control order" id="order" name="order" value="<?php echo $order; ?>">
            <p><?php echo form_error('order') ?></p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-12">
            <label for="level" class="control-label">Level</label>
            <?php echo $level; ?>
            <p><?php echo form_error('level') ?></p>
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
    <a href="<?php echo site_url('menu/admin') ?>" class="btn btn-default">Kembali</a>
    
    <?php echo form_close();?>
</section>

<script type="text/javascript">
	$(document).ready(function() {
		$('.mn-ManajemenMenu, .mn-Setting').addClass('active');
		$('select[name="level"], .is_parent, .is_active').select2({width: '100%'});
		
		setIcon();
		
		$('.is_parent').change(function() {
			var id_parent = $(this).val();
			var icon = $(".icon");
			if (id_parent > 0) {
				icon.val('fa fa-angle-right');
				icon.prop('readonly', true);
			} else {
				icon.val('');
				icon.prop('readonly', false);
			}
			
			$.ajax({
				url: '<?php echo base_url("menu/admin/getLastOrderByIdParent") ?>',
				type: 'POST',
				dataType: 'JSON',
				data: {id: id_parent},
				success: function (json) {
					$(".order").val(json.order);
				}
			});
		});
		
		$(".icon").keyup(function() {
			setIcon();
		});
		
		$("body").click(function() {
			setIcon();
		});
		
		$('.content form').validate({
		   ignore: [],
		   errorClass: 'error',
		   rules: {
               name : {required: true},
               link : {required: true},
               icon : {required: true},
			   is_active : {required: true},
			   order : {required: true},
			   level : {required: true},
		   },
		   messages: {
			   name : {required: "Nama menu tidak boleh kosong"},
               link : {required: "Link tidak boleh kosong"},
               icon : {required: "Icon tidak boleh kosong"},
			   is_active : {required: "Status tidak boleh kosong"},
			   order : {required: "Urutan tidak boleh kosong"},
			   level : {required: "Level tidak boleh kosong"},
		   }
	   });
	});
	
	function setIcon () {
		var icon = $(".icon").val();
		if (icon != "") {
			$('.show-icon').html("<i class='"+icon+"'></i>");
		}
	}
</script>