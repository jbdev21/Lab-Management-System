import './bootstrap';

import SalesOrderProductsInput from "./components/SalesOrder/ProductsInput/MainComponent.vue";
import UsageRawMaterialInput from "./components/Usage/RawMaterialsInput/MainComponent.vue";
import PurchaseOrderRawMaterialInput from "./components/PurchaseOrder/RawMaterialsInput/MainComponent.vue";
import PurchaseOrderGeneralInput from "./components/PurchaseOrder/GeneralInput/MainComponent.vue";
import DeliveryReceiptsInput from "./components/AcknowledgementReceipt/DeliveryReceiptsInput/MainComponent.vue";
import PriceRequestProductsInput from "./components/PriceRequest/ProductsInput/MainComponent.vue";
import NotificationComponent from "./components/Notification/MainComponent.vue";
import { createApp } from 'vue/dist/vue.esm-bundler'
import Swal from 'sweetalert2'
import timeago from 'vue-timeago3'

createApp({})
	.component('sales-order-products-input', SalesOrderProductsInput)
	.component('usage-raw-material-input', UsageRawMaterialInput)
	.component('purchase-order-raw-material-input', PurchaseOrderRawMaterialInput)
	.component('purchase-order-general-input', PurchaseOrderGeneralInput)
	.component('delivery-receipt-input', DeliveryReceiptsInput)
	.component('price-request-products-input', PriceRequestProductsInput)
	.component('notification-component', NotificationComponent)
	.use(timeago)
	.mount("#app");

const permissionSwitches = document.querySelectorAll('.role-permission-switch');
permissionSwitches.forEach(e => {
	e.addEventListener("change", function(event){
		var checked = e.checked;
		var permission = e.dataset.permission;
		var role = e.dataset.role;
		axios.post('/api/update-role-permission',{
			checked: checked,
			role_id: role,
			permission: permission
		})
		.then(e => {
			
		})
		.catch( e => {
			console.log(e.response.data);
		})
	})
})

const overlayedForms = document.querySelectorAll('.overlayed-form');
overlayedForms.forEach(e => {
	e.addEventListener("submit", function(event){
		document.body.classList.add("overlay-body")
		document.getElementById("overlay-box").classList.add("show-overlay")
	})
})

const selectChangeSubmit = document.querySelectorAll('.select-change-submit');
selectChangeSubmit.forEach(e => {
	e.addEventListener("change", function(event){
		this.form.submit()
	})
})

const deleteButton = document.querySelectorAll('.delete-button');
deleteButton.forEach(e => {
	var type = e.dataset.type;
	e.addEventListener("click", function(event){
		Swal.fire({
			title: "Are you sure?",
			text: "You are about to delete an item.",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, delete it!"
		  }).then((result) => {
			if (result.isConfirmed) {
				if(type == "form"){
					document.getElementById(e.dataset.form).submit();
				}
			}
		  });
	})
	return false;
})

document.getElementById("booking-submit-for-approval")?.addEventListener("click", function(event){
	Swal.fire({
		title: "Are you sure?",
		text: "Submmiting booking for approval",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, Proceed!"
	  }).then((result) => {
		if (result.isConfirmed) {
			document.getElementById('booking-submit-for-approval-form').submit();
		}
	  });
})

document.getElementById("booking-generate-so")?.addEventListener("click", function(event){
	Swal.fire({
		title: "Are you sure?",
		text: "Generate Sales Order from this Booking",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, Proceed!"
	  }).then((result) => {
		if (result.isConfirmed) {
			document.getElementById('booking-generate-so-form').submit();
		}
	  });
})


const toogleDarkMode = document.querySelectorAll('#toogleDarkMode')[0];
if(toogleDarkMode){
	toogleDarkMode.addEventListener("change", function(e){
		var checked = toogleDarkMode.checked;
		axios.post('/dashboard/dark-mode/update', {
				darkmode: checked
			})
			.then(()=>{
				var element = document.body;
				element.classList.toggle("dark");
			})
			.catch( error => {
				console.log(error)
			})
	})
}

/* ===== Responsive Sidepanel ====== */
const sidePanelToggler = document.getElementById('sidepanel-toggler'); 
const sidePanel = document.getElementById('app-sidepanel');  
const sidePanelDrop = document.getElementById('sidepanel-drop'); 
const sidePanelClose = document.getElementById('sidepanel-close'); 

if(sidePanelToggler){
	sidePanelToggler.addEventListener('click', () => {
		if (sidePanel.classList.contains('sidepanel-visible')) {
			sidePanel.classList.remove('sidepanel-visible');
			sidePanel.classList.add('sidepanel-hidden');
			
		} else {
			sidePanel.classList.remove('sidepanel-hidden');
			sidePanel.classList.add('sidepanel-visible');
		}
	});
}

if(sidePanelClose){
	sidePanelClose.addEventListener('click', (e) => {
		e.preventDefault();
		sidePanelToggler.click();
	});
}

if(sidePanelDrop){
	sidePanelDrop.addEventListener('click', (e) => {
		sidePanelToggler.click();
	});
}
