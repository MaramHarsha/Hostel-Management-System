function deletetenant(tenid) {
	Swal.fire({
		title: lang.are_you_sure,
		text: lang.ten_del_confirm,
		type: 'warning',
		showCancelButton: true,
		confirmButtonText: lang.tdc_yes,
		cancelButtonText: lang.tdc_no,
		}).then((result) => {
			if (result.value) {
				$.ajax({url: base_url + 'index.php/admin/deleteTenant'
					, type: "POST"
					, data: {tenantid: tenid}
					, dataType: "json"
					, async : false
					, success: function (responseData) {
						if(responseData.status == 'success')
						{
							show_notification(lang.tensuccess,'success');
							window.location.replace(base_url+'index.php/admin/tenants');
						}
						else
						{
							Swal.fire(lang.actionterminate, lang.tenerror, "error");
						}
					}
				});
			}
		});
}

function deleteroom(roomid) {
	Swal.fire({
		title: lang.are_you_sure,
		text: lang.room_del_confirm,
		type: 'warning',
		showCancelButton: true,
		confirmButtonText: lang.tdc_yes,
		cancelButtonText: lang.tdc_no,
		}).then((result) => {
			if (result.value) {
				$.ajax({url: base_url + 'index.php/admin/deleteRoom'
					, type: "POST"
					, data: {roomid: roomid}
					, dataType: "json"
					, async : false
					, success: function (responseData) {
						if(responseData.status == 'success')
						{
							show_notification(lang.roomsuccess,'success');
							window.location.replace(base_url+'index.php/admin/rooms');
						}
						else
						{
							Swal.fire(lang.actionterminate, lang.roomerror, "error");
						}
					}
				});
			}
		});
}


function deletebed(bedid) {
	Swal.fire({
		title: lang.are_you_sure,
		text: lang.bed_del_confirm,
		type: 'warning',
		showCancelButton: true,
		confirmButtonText: lang.tdc_yes,
		cancelButtonText: lang.tdc_no,
		}).then((result) => {
			if (result.value) {
				$.ajax({url: base_url + 'index.php/admin/deleteBed'
					, type: "POST"
					, data: {bedid: bedid}
					, dataType: "json"
					, async : false
					, success: function (responseData) {
						if(responseData.status == 'success')
						{
							show_notification(lang.bedsuccess,'success');
							window.location.replace(base_url+'index.php/admin/beds');
						}
						else
						{
							Swal.fire(lang.actionterminate, lang.bederror, "error");
						}
					}
				});
			}
		});
}



function deletees(esid) {
	Swal.fire({
		title: lang.are_you_sure,
		text: lang.delconfirm,
		type: 'warning',
		showCancelButton: true,
		confirmButtonText: lang.tdc_yes,
		cancelButtonText: lang.tdc_no,
		}).then((result) => {
			if (result.value) {
				$.ajax({url: base_url + 'index.php/admin/deleteEs'
					, type: "POST"
					, data: {esid: esid}
					, dataType: "json"
					, async : false
					, success: function (responseData) {
						if(responseData.status == 'success')
						{
							show_notification(lang.essuccess,'success');
							window.location.replace(base_url+'index.php/admin/extraservices');
						}
						else
						{
							Swal.fire(lang.actionterminate, lang.eserror, "error");
						}
					}
				});
			}
		});
}

function retractBed(bedUid) {
	Swal.fire({
		title: lang.are_you_sure,
		text: lang.bed_ten_retract_confirm,
		type: 'warning',
		showCancelButton: true,
		confirmButtonText: lang.ret_yes,
		cancelButtonText: lang.tdc_no,
		}).then((result) => {
			if (result.value) {
				$.ajax({url: base_url + 'index.php/admin/retractBed'
					, type: "POST"
					, data: {bedUid: bedUid}
					, dataType: "json"
					, async : false
					, success: function (responseData) {
						if(responseData.status == 'success')
						{
							show_notification(lang.bedretractsuccess,'success');
							location.reload();
						}
						else
						{
							Swal.fire(lang.actionterminate, lang.bedretracterror, "error");
						}
					}
				});
			}
		});
}

function retractTenBed(tenUid) {
	Swal.fire({
		title: lang.are_you_sure,
		text: lang.ten_bed_retract_confirm,
		type: 'warning',
		showCancelButton: true,
		confirmButtonText: lang.ret_yes,
		cancelButtonText: lang.tdc_no,
		}).then((result) => {
			if (result.value) {
				$.ajax({url: base_url + 'index.php/admin/retractTenBed'
					, type: "POST"
					, data: {tenuid: tenUid}
					, dataType: "json"
					, async : false
					, success: function (responseData) {
						if(responseData.status == 'success')
						{
							show_notification(lang.bedretractsuccess,'success');
							location.reload();
						}
						else
						{
							Swal.fire(lang.actionterminate, lang.bedretracterror, "error");
						}
					}
				});
			}
		});
}


function loadLoginOrFpass(pgid){
	if(pgid == 'fpass')
	{
		$("#loginPgDiv").fadeOut("slow");
		$("#fpassPgDiv").fadeIn("slow");
	}
	else
	{
		$("#fpassPgDiv").fadeOut("slow");
		$("#loginPgDiv").fadeIn("slow");
	}
}

function show_notification(msg,notifytype)
{
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 3000
	});
	Toast.fire({
        type: notifytype,
        title: msg
	});
}

function formatRoomSelect(data) {
	var availablebeds = $(data.element).data('availablebeds');
	var totalbeds = $(data.element).data('totalbeds');
	var baseprice = $(data.element).data('baseprice');
	var classAttr = $(data.element).attr('class');
	var hasClass = typeof classAttr != 'undefined';
	classAttr = hasClass ? ' ' + classAttr : '';
  
	var $result = $(
	  '<div class="row">' +
	  '<div class="col-md-3 col-xs-3' + classAttr + '">' + data.text + '</div>' +
	  '<div class="col-md-3 col-xs-3' + classAttr + '">' + availablebeds + '</div>' +
	  '<div class="col-md-3 col-xs-3' + classAttr + '">' + totalbeds + '</div>' +
	  '<div class="col-md-3 col-xs-3' + classAttr + '">' + baseprice + '</div>' +
	  '</div>'
	);
	return $result;
}

$(function () {



bsCustomFileInput.init();

$("#example1").DataTable({
	"language": {
		"url": base_url+"/assets/backend/plugins/datatables/languages/"+language+".json"
	}
});
$('#example2').DataTable({
  "paging": true,
  "lengthChange": false,
  "searching": false,
  "ordering": true,
  "info": true,
  "autoWidth": false,
  "responsive": true
});

$('.datepicker').datepicker({
	language: languageabbr,
	format: 'yyyy-mm-dd',
    autoclose: true
});

$('.daterangeinput').each(function() {
    $(this).datepicker('clearDates');
});

$('.smartselect').select2({ theme: 'bootstrap4' });

$('.roomselect').select2({
    width: '100%',
	templateResult: formatRoomSelect,
	theme: 'bootstrap4'
});

//iCheck for checkbox and radio inputs
$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
  checkboxClass: 'icheckbox_minimal-blue',
  radioClass: 'iradio_minimal-blue'
});
//Red color scheme for iCheck
$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
  checkboxClass: 'icheckbox_minimal-red',
  radioClass: 'iradio_minimal-red'
});
//Flat red color scheme for iCheck
$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
  checkboxClass: 'icheckbox_flat-green',
  radioClass: 'iradio_flat-green'
});

$('#rent_period').change(function(){
	if($('#rent_period').val() == 'monthly')
	{
		$('#rent_period_for_rent').text('/Month');
	}
	else if($('#rent_period').val() == 'daily')
	{
		$('#rent_period_for_rent').text('/Day');
	}
	else if($('#rent_period').val() == 'weekly')
	{
		$('#rent_period_for_rent').text('/Week');
	}
	else if($('#rent_period').val() == 'yearly')
	{
		$('#rent_period_for_rent').text('/Year');
	}
	else
	{
		$('#rent_period_for_rent').text('/Month');
	}
});

$('#tenantes').change(function(){
	var esprice = $(this).find(':selected').data('baseprice');
	$('#bedbaseprice').val(parseFloat(esprice));
	$('#bedbaseprice').change();
});


$('#tenantroom').change(function(){
	var roomdata = {
		roomid : $('#tenantroom').val()
	};
	var baseprice = $(this).find(':selected').attr('data-baseprice');
	var roomname = $(this).find(':selected').text();
	var totalprice = baseprice.slice(2);

	$('.roomselectionform').LoadingOverlay("show");
	$.ajax({url: base_url + 'index.php/admin/getBeds'
		, type: "POST"
		, data: roomdata
		, dataType: "json"
		, async : false
		, success: function (responseData) {
			$('#tenantbed').find('option:not(:first)').remove();
			$.each(responseData.allbeds, function(key, value) {   
				$('#tenantbed')
					.append($("<option></option>")
							   .attr("value",value.bed_uid)
							   .text(value.bed_name)); 
				$('#bedbaseprice').val(parseFloat(totalprice));
				$('#ten_room_name').val(roomname);
				$('#bedbaseprice').change();
		   });
		   $('.smartselect').select2({ theme: 'bootstrap4' });
		}
		, error: function (errmsg) {
			alert(JSON.stringify(errmsg));
		}
		, complete: function () {
			$('.roomselectionform').LoadingOverlay("hide");
		}
	});
});


$('#pay_invoice').change(function(){
	var invdata = {
		invid : $('#pay_invoice').val()
	};
	$.ajax({url: base_url + 'index.php/admin/getAllPaymentsForInvoice'
		, type: "POST"
		, data: invdata
		, dataType: "json"
		, async : false
		, success: function (responseData) {
			$('#total').val(responseData.amnts.total);
			$('#paid').val(responseData.amnts.paid);
			$('#balance').val(responseData.amnts.balance);
		}
	});
});


$('#tenantforinvoice').change(function(){
	var tendata = {
		tenuid : $('#tenantforinvoice').val()
	};
	$.ajax({url: base_url + 'index.php/admin/getAllInvoicesForTenant'
		, type: "POST"
		, data: tendata
		, dataType: "json"
		, async : false
		, success: function (responseData) {
			$('#invoiceid').find('option:not(:first)').remove();
			$.each(responseData.allinvs, function(key, value) {   
				$('#invoiceid')
					.append($("<option></option>")
							   .attr("value",value.inv_id)
							   .text(value.inv_id+' - '+value.inv_for+' - '+moment(value.inv_created).format('DD MMM YYYY'))); 
		   });
		   $('.smartselect').select2({ theme: 'bootstrap4' });
		}
	});
});


$('#invoiceid').change(function(){
	var invdata = {
		invid : $('#invoiceid').val()
	};
	$.ajax({url: base_url + 'index.php/admin/getInvoiceDetails'
		, type: "POST"
		, data: invdata
		, dataType: "json"
		, async : false
		, success: function (responseData) {
			$('#bedbaseprice').val(responseData.invdetails.invoice.inv_amnt);
			$('#tax1per').val(responseData.invdetails.invoice.inv_tax_per);
			$('#tax2per').val(responseData.invdetails.invoice.inv_tax2_per);
			$('#bedtotalprice').val(responseData.invdetails.invoice.inv_total);
		}
	});
});

$('#toggleFullscreen').click(function(){
	$(document).toggleFullScreen();
});

$('#tenantbed').change(function(){
	var bedname = $(this).find(':selected').text();
	$('#ten_bed_name').val(bedname);
});

$("#bedpaidprice").focusout(function(){
	var totalprice = $("#bedtotalprice").val();
	var paidprice = $(this).val();
	if(paidprice == '')
	{
		$(this).val(0);
	}

	$("#bedbalprice").val(totalprice-paidprice);
	
});


$("#tax1per,#tax2per").focusout(function(){
	var tax1per = parseFloat($("#tax1per").val());
	var tax2per = parseFloat($("#tax2per").val());
	var baseprice = parseFloat($("#bedbaseprice").val());

	var taxamnt1 = parseFloat((tax1per / 100) * baseprice);
	var taxamnt2 = parseFloat((tax2per / 100) * baseprice);

	$("#bedtotalprice").val(baseprice+taxamnt1+taxamnt2);
	
});

$(document).on('change', '#bedbaseprice', function() {
	var tax1per = parseFloat($("#tax1per").val());
	var tax2per = parseFloat($("#tax2per").val());
	var baseprice = parseFloat($("#bedbaseprice").val());
	var taxamnt1 = parseFloat((tax1per / 100) * baseprice);
	var taxamnt2 = parseFloat((tax2per / 100) * baseprice);

	$("#bedtotalprice").val(baseprice+taxamnt1+taxamnt2);
});

$('iframe.ten_report_frame').iframeAutoHeight({
	minHeight: 240,
	heightOffset: 50
});
	
});


function payWithPaystack(custemail, currency){
    var handler = PaystackPop.setup({
      key: pays_pub_key,
      email: custemail,
      amount: $('#pay_amnt').val()*100,
      currency: currency,
      ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
      callback: function(response){
		  $('#pay_transid').val(response.reference);
		  $('#paymentForm').submit();
      },
      onClose: function(){
          alert('Transaction Cancelled.');
      }
    });
    handler.openIframe();
}

function payWithRazorpay(custemail, currency, custname, dhpname)
{
	var options = {
		"key": razp_web_key,
		"amount": $('#pay_amnt').val()*100,
		"currency": currency,
		"name": dhpname,
		"handler": function (response){
			$('#pay_transid').val(response.razorpay_payment_id);
		  	$('#paymentForm').submit();
		},
		"prefill": {
			"name": custname,
			"email": custemail,
			"contact": ""
		}
	};

	var rzp1 = new Razorpay(options);
	rzp1.open();
}