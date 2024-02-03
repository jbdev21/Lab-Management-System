<template>
    <div class="item p-3">
        <div class="row gx-2 justify-content-between align-items-center">
            <div class="col-auto">
                <img class="profile-image" :src="notification.icon" alt="">
            </div>
            <div class="col">
                <div class="info"> 
                    <div class="desc">{{ notification.details }}</div>
                    <div></div>
                    <div class="meta">
                        <timeago 
                        :datetime="notification.created_at"
                        :converter-options="{
                                includeSeconds: true,
                                addSuffix: false,
                                useStrict: false,
                                }"
                        />
                    </div>
                </div>
            </div> 
        </div>
        <a class="link-mask" :href="notification.link"></a>
    </div>
</template>

<script>
export default {
    props: ['notification']
}
</script>

<style>

</style>