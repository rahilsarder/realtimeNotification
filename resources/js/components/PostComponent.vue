<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col md-7">
                <div class="card">
                    <div class="card-header">Create new Post</div>
                    <div class="card-body">
                        <p id="success"></p>
                        <div class="container">
                            <ul v-for="chat in apiComment" :key="chat.id">
                                <li>
                                    <b>{{ chat.user.name }}</b>
                                    {{ chat.title }}
                                </li>
                            </ul>
                        </div>

                        <input
                            type="text"
                            name="title"
                            v-model="comment.title"
                        />
                        <button
                            type="submit"
                            class="btn btn-primary"
                            @click="addPost"
                        >
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: ["user", "post"],
    data() {
        return {
            comment: {
                title: "",
                user_id: this.user.id,
            },
            apiComment: [],
        };
    },
    methods: {
        addPost() {
            axios.post("/post", this.comment).then((response) => {
                this.comment = {
                    title: "",
                };
            });
        },
    },
    created() {
        console.log(this.userId);
        Echo.channel("notification-channel").listen("PostCreated", (post) => {
            post.post = { ...post.post, user: post.user };
            console.log(post.post);
            this.apiComment.push(post.post);
        });
        axios.get("/api/post").then((response) => {
            this.apiComment = response.data;
        });
    },
};
</script>
