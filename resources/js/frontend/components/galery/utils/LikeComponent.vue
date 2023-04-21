<template>
    <div class="d-flex align-items-center">
        <div><span v-text="likeTotal"></span> Suka </div>
        <div class="ml-1">
            <span @click="like" style="cursor: pointer;" v-if="!liked">
                <i class="far fa-heart fa-lg"></i>
            </span>
            <span @click="unlike" style="cursor: pointer;" v-else>
                <i class="fas fa-heart fa-lg" style="color: #e22222;"></i>
            </span>
        </div>
    </div>
</template>

<script>

export default {
    props: [
        'totalCount',
        'postId',
        'userId',
        'likes'
    ],

    data(){
        return {
            likeTotal: 0,
            liked: false,
            clickLike: false
        }
    },

    mounted(){
        this.likeTotal = this.totalCount;
        this.likes.forEach(like => {
            if (like.user_id == this.userId) {
                this.liked = true;
            }
        });
    },

    methods: {
        like : function () {
            this.clickLike = true;
            this.liked = true;
            const url = `/galery/action/${this.postId}/like`;
            axios.put(url)
                .then(response => {
                    console.log(response);
                    this.likeTotal++;
                })
                .catch(error => {
                    console.log(error);
                    console.log(`Response: ${JSON.stringify(error.response)}`);

                    if (error.response) {
                        if (error.response.status == 401) {
                            Swal.fire(
                                '',
                                'Anda harus login terlebih dahulu',
                                'error'
                            )
                            this.likeTotal = error.response.data.post
                        }else{
                            Swal.fire(
                                'Sambungan gagal!',
                                'Cobalah beberapa saat lagi',
                                'error'
                            )
                        }
                        this.liked = false;
                    }else{
                        Swal.fire(
                            'Sambungan gagal!',
                            'Cobalah beberapa saat lagi',
                            'error'
                        )

                        this.liked = false;
                    }

                });

        },
        unlike : function () {
            this.clickLike = true;
            this.liked = false;
            const url = `/galery/action/${this.postId}/unlike`;
            axios.put(url)
                .then(response => {
                    console.log(response);
                    this.likeTotal--;
                    this.liked = false;
                })
                .catch(error => {
                    console.log(error);
                    console.log(`Response: ${JSON.stringify(error.response)}`);

                    if (error.response) {
                        if (error.response.status == 401) {
                            Swal.fire(
                                '',
                                'Anda harus login terlebih dahulu',
                                'error'
                            )
                            this.likeTotal = error.response.data.post
                            this.liked = false;
                        }else{
                            Swal.fire(
                                'Sambungan gagal!',
                                'Cobalah beberapa saat lagi',
                                'error'
                            )
                                this.liked = true;
                        }
                    }else{
                        Swal.fire(
                            'Sambungan gagal!',
                            'Cobalah beberapa saat lagi',
                            'error'
                        )

                        this.liked = true;
                    }

                });

        }
    }
}
</script>

<style>

</style>
