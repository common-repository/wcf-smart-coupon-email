<div class="container" style="margin-top:30px; max-width:100%;">
<h3>Welcome to WCF Smart Coupon Email</h3><br>
 <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="cooa-tab" data-bs-toggle="tab" data-bs-target="#cooa-tab-pane" type="button" role="tab" aria-controls="cooa-tab-pane" aria-selected="true">Coupon On Order Amount</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="moc-tab" data-bs-toggle="tab" data-bs-target="#moc-tab-pane" type="button" role="tab" aria-controls="moc-tab-pane" aria-selected="false">Multi Order Coupon (Pro)</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="cac-tab" data-bs-toggle="tab" data-bs-target="#cac-tab-pane" type="button" role="tab" aria-controls="cac-tab-pane" aria-selected="false">Coupon after certain days (Pro)</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="bce-tab" data-bs-toggle="tab" data-bs-target="#bce-tab-pane" type="button" role="tab" aria-controls="bce-tab-pane" aria-selected="false">Birthady Coupon (Pro)</button>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="cooa-tab-pane" role="tabpanel" aria-labelledby="cooa-tab" tabindex="0">
  <br>
  <h3>Coupon On Order Amount</h3>
	<?php include('order_amount_form.php'); ?>
  </div>
  <div class="tab-pane fade" id="moc-tab-pane" role="tabpanel" aria-labelledby="moc-tab" tabindex="0">
   <br><h3>Multi Order Coupon (Pro)</h3>
	<p>This Feature is available in Pro Version</p>
	
  </div>
  <div class="tab-pane fade" id="cac-tab-pane" role="tabpanel" aria-labelledby="cac-tab" tabindex="0">
   <br><h3>Coupon after certain days (Pro)</h3>
	<p>This Feature is available in Pro Version</p>
  </div>
  <div class="tab-pane fade" id="bce-tab-pane" role="tabpanel" aria-labelledby="bce-tab" tabindex="0">
   <br><h3>Birthady Coupon (Pro)</h3>
	<p>This Feature is available in Pro Version</p>
	</div>
</div>
</div>