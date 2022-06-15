<template>
    <div class="col-7 px-0">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ room.name }}</h3>
            </div>
            <div class="px-4 py-5 chat-box bg-white" v-chat-scroll>
                <!-- Sender Message-->
                <div v-for="chat in apiComment" :key="chat.id">
                    <div v-if="chat.user.id !== user.id">
                        <div class="media w-50 mb-3">
                            <div class="media-body ml-3">
                                <p class="text-small mb-0 text-muted">
                                    <span class="text-muted">
                                        <b>{{ chat.user.name }}</b>
                                    </span>
                                    <!-- <span class="text-muted">{{
                                        chat.created_at
                                    }}</span> -->
                                </p>
                                <div class="bg-light rounded py-2 px-3 mb-2">
                                    <p class="text-small mb-0 text-muted">
                                        {{ chat.title }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reciever Message-->
                    <div v-else>
                        <div class="media w-50 ms-auto mb-3">
                            <div class="media-body">
                                <p class="text-small mb-0 text-muted">
                                    <span class="text-muted">{{
                                        chat.user.name
                                    }}</span>
                                    <!-- <span class="text-muted">{{
                                        chat.created_at
                                    }}</span> -->
                                </p>
                                <div class="bg-primary rounded py-2 px-3 mb-2">
                                    <p class="text-small mb-0 text-white">
                                        {{ chat.title }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Typing area -->
            <div class="input-group">
                <input
                    v-model="comment.title"
                    type="text"
                    placeholder="Type a message"
                    aria-describedby="button-addon2"
                    class="form-control rounded-0 border-0 py-4 bg-light"
                    @keyup.enter="addPost"
                />
                <div class="input-group-append">
                    <button
                        id="button-addon2"
                        type="submit"
                        class="btn btn-link"
                        @click="addPost"
                    >
                        <i class="fa fa-paper-plane big"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import VueChatScroll from "vue-chat-scroll";

export default {
    props: ["user", "post", "roomid", "room"],
    components: {
        VueChatScroll,
    },
    data() {
        return {
            comment: {
                title: "",
                user_id: this.user.id,
            },
            apiComment: [],
            roomInfo: {},
        };
    },
    methods: {
        addPost() {
            axios
                .post(`/chat/${this.roomid}`, this.comment)
                .then((response) => {
                    this.comment = {
                        title: "",
                    };
                });
        },
    },
    created() {
        console.log(this.user);
        Echo.channel("notification-channel-" + this.roomid).listen(
            "PostCreated",
            (post) => {
                console.log(post);
                post.post = { ...post.post, user: post.user };
                console.log(post.post);
                this.apiComment.push(post.post);
            }
        );
        axios.get("/api/chat/" + this.roomid).then((response) => {
            this.apiComment = response.data;
        });
        axios.get("/api/roomid/" + this.roomid).then((response) => {
            this.roomInfo = response.data;
        });
    },
};
</script>
