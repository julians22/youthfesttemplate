<template>
    <div class="btn-group dropright" :ref="`parent-dropdown-${postId}`">
        <button type="button" class="btn btn-primary btn-sm dropdown-toggle sharer"  data-toggle="dropdown" aria-expanded="false">
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

    mounted(){
        const parentDropdown = this.$refs[`parent-dropdown-${this.postId}`];
        $(parentDropdown).on('show.bs.dropdown', function () {
            $('main').addClass('overflow-auto');
            $('main').removeClass('overflow-hidden');
        });

        $(parentDropdown).on('hide.bs.dropdown', function () {
            $('main').addClass('overflow-hidden');
            $('main').removeClass('overflow-auto');
        });
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
