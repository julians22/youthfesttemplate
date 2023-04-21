<template>
    <div class="btn-group dropright">
        <button type="button" class="btn btn-primary btn-sm dropdown-toggle sharer" data-toggle="dropdown" aria-expanded="false">
            Bagikan

            <i class="fas fa-share-alt ml-1"></i>
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" target="_blank" href="#" :key="key" v-for="(link, key) in linksData" @click.prevent="shareLink(key, link, postId)">
                {{ key }}
            </a>
        </div>
    </div>
</template>

<script>

export default {
    props: [
        'linksData',
        'postId'
    ],
    data(){
        return {
            isOpen: false
        }
    },

    methods: {
        shareLink: function(target, urlSlug, postId){
            // window.open(urlSlug, '_blank', 'toolbar=0,location=0,menubar=0')
            const url = `/galery/action/${this.postId}/share`;
            axios.put(url)
                .then(response => {
                    console.log(response);
                    if (response.data.message == 'success') {
                    }
                });
        }
    }
}
</script>

<style>

</style>
