<template>
    <div class="app-utility-item app-notifications-dropdown dropdown">    
        <a class="dropdown-toggle no-toggle-arrow" @click="loadNotification" id="notifications-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" title="Notifications">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bell icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2z"/>
                <path fill-rule="evenodd" d="M8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
            </svg>
            <span class="icon-badge" v-if="unreadNotifications > 0">
                {{ unreadNotifications }}
            </span>
        </a>
        <div class="dropdown-menu p-0" aria-labelledby="notifications-dropdown-toggle">
            <div class="dropdown-menu-header p-3">
                <h5 class="dropdown-menu-title mb-0">Notifications</h5>
            </div>
            <div class="dropdown-menu-content">
                <Item v-for="notificationItem in notifications" :notification="notificationItem" :key="notificationItem.id"></Item>

                <div class="item p-3" v-if="fetching">
                    <div class="row gx-2 justify-content-between align-items-center">
                        <div class="col text-center">
                            Loading...
                        </div>
                    </div>
                </div>
                <div class="item p-3" v-if="notifications.length < 1 && !fetching">
                    <div class="row gx-2 justify-content-between align-items-center">
                        <div class="col text-center">
                            No Notication yet
                        </div>
                    </div>
                </div>
                
            </div>
            
            <div class="dropdown-menu-footer p-2 text-center">
                <a href="notifications.html">View all</a>
            </div>
                        
        </div>	
    </div>	
</template>

<script>
import Item from "./Item.vue"
export default {
    props: ['user', 'unread'],
    data(){
        return {
            notifications: [],
            fetching: false,
            loaded: false,
            unreadNotifications: this.unread
        }
    },
    components:{
        Item
    },
    created(){
        this.listenToNotification()
    },
    methods:{
        listenToNotification(){
            Echo.private('App.Models.User.' + this.user)
                .notification((notification) => {
                    this.unreadNotifications++
                    if(this.notifications.length > 8){
                        this.notifications.pop();
                    }
                    this.notifications.unshift(notification)
                    this.notifyMe("Johnwealth Laboratories",{
                        body: notification.details,
                        icon: notification.icon
                    })
                });
        },
        loadNotification(){
            this.unreadNotifications = 0
            if(!this.loaded){
                this.fetching = true
                axios.get("/api/notification/" + this.user + "/list")
                    .then(response => {
                        this.loaded = true
                        this.notifications = response.data.data
                        this.fetching = false
                    })
                    .catch( error => {
                        console.log(error)
                        this.fetching = false
                    })
            }
        },

        notifyMe(title, options) {
            // Let's check if the browser supports notifications
            if (window.Notification && Notification.permission !== "granted") {
                Notification.requestPermission(function (status) {
                if (Notification.permission !== status) {
                    Notification.permission = status;
                }
                });
            }
            
            if (!("Notification" in window)) {
                alert("This browser does not support desktop notification");
            }

            // Let's check whether notification permissions have already been granted
            else if (Notification.permission === "granted") {
                // If it's okay let's create a notification
                var notification = new Notification(title, options);
            }	

            // Otherwise, we need to ask the user for permission
            else if (Notification.permission !== "denied") {
                Notification.requestPermission().then(function (permission) {
                    // If the user accepts, let's create a notification
                    if (permission === "granted") {
                        var notification = new Notification(title, options);
                    }
                });
            }
            
            // setTimeout(notification.close.bind(notification), 4000);
        }
    }
}
</script>

<style>

</style>