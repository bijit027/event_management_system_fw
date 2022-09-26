<template>
    <EventInputView
        v-bind:event="value"
        v-bind:image="image"
        v-bind:button="button"
        v-bind:errors="errors"
        @form-submit="onSubmit"
    />
</template>

<script>
import Rest from "@/admin/Bits/Rest";
import { ElButton, ElMessage } from "element-plus";
import EventInputView from "../Pieces/FormInput/EventInputView.vue";
export default {
    props: ["eventID"],
    emits: ["onUpdate"],
    data() {
        return {
            // eventID: this.$route.params.eventID,
            events: {},
            value: {},
            button: "Update",
            organizer: {},
            ID: "",
            errors: [],
            categoryID: "",
        };
    },
    components: {
        EventInputView,
    },

    watch: {
        eventID() {
            console.log(this.eventID);
            if (this.eventID) {
                this.fetchData();
            } else {
                this.value = {};
            }
        },
    },

    // mounted() {
    //     console.log("mounted");
    //     this.fetchData();
    // },
    methods: {
        fetchData() {
            const that = this;
            console.log(that.eventID);
            Rest.get(`singleEventData/${that.eventID}`)
                .then((response) => {
                    that.event = response.single_event_data;
                    console.log(that.event);
                    that.value = JSON.parse(response.single_event_data.eventData);
                    that.eventID = "";
                })
                .catch((err) => console.log(err));
            // const that = this;
            // EMS.adminGet({
            //     route: "get_single_eventData",
            //     id: that.eventID,
            //     ems_nonce: ajax_url.ems_nonce,
            // })
            //     .then((response) => {
            //         that.event = response.data.single_event_data;
            //         that.value = JSON.parse(that.event.eventData);
            //         that.categoryID = that.value.categoryID;
            //     })
            //     .fail((error) => {
            //         ElMessage.error(error.responseJSON.data.error);
            //     });
        },

        onSubmit() {
            const that = this;
            Rest.put(`updateEventData/${that.eventID}`, that.value)
                .then((response) => {
                    console.log(response.data.message);
                    that.value = {};
                    that.$emit("onUpdate");

                    // router.go("/");
                    ElMessage({
                        showClose: true,
                        message: response.data.message,
                        type: "success",
                    });
                })
                .catch((error) => {
                    // that.$emit("onUpdate");
                    // console.log(error);
                    that.errors = error.responseJSON;
                });
            // if (typeof this.value.category === "string") {
            //     this.value.category = this.categoryID;
            // }
            // const that = this;
            // console.log(that.value);
            // EMS.adminPost({
            //     route: "create_event",
            //     id: that.eventID,
            //     ems_nonce: ajax_url.ems_nonce,
            //     data: that.value,
            //     // file: that.image,
            // })
            //     .then((response) => {
            //         ElMessage({
            //             showClose: true,
            //             message: response.data.message,
            //             type: "success",
            //         });
            //         that.$router.push({
            //             name: "AllEvents",
            //         });
            //     })
            //     .fail((error) => {
            //         that.errors = error.responseJSON.data;
            //         if (error.responseJSON.data.error) {
            //             ElMessage.error(error.responseJSON.data.error);
            //         }
            //     });
        },
    },
};
</script>

<style scoped>
.box-card {
    width: 60%;
    margin: auto;
    margin-top: 50px;
}

.close_button {
    text-align: end;
}
</style>
