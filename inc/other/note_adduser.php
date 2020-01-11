<?php
// Script by JDCode
require("../../mainconfig.php");

if (isset($_POST['level'])) {
    if ($_POST['level'] == "Member") {
	    $price = $cfg_member_price;
	    $bonus = $cfg_member_bonus;
	} 
	if ($_POST['level'] == "Agen") {
	    $price = $cfg_agen_price;
	    $bonus = $cfg_agen_bonus;
	} 
	if ($_POST['level'] == "Reseller") {
	    $price = $cfg_reseller_price;
	    $bonus = $cfg_reseller_bonus;
	}
	if ($_POST['level'] == "Admin") {
	    $price = $cfg_admin_price;
	    $bonus = $cfg_admin_bonus;
	}
}
	?>
	                                        <div class="form-row">
    											<div class="form-group col-md-6">
    												<label>Biaya Pendaftaran</label>
        												<div class="input-group">
                                            				<div class="input-group-prepend">
                                            					<span class="input-group-text">Rp</span>
                                            				</div>
                                            				<input type="number" class="form-control" value="<?php echo number_format($price,0,',','.'); ?>" readonly>
                                            			</div>
    											</div>
											
    											<div class="form-group col-md-6">
    												<label>Bonus Saldo</label>
        												<div class="input-group">
                                            				<div class="input-group-prepend">
                                            					<span class="input-group-text">Rp</span>
                                            				</div>
                                            				<input type="number" class="form-control" value="<?php echo number_format($bonus,0,',','.'); ?>" readonly>
                                            			</div>
    											</div>
											</div>
	