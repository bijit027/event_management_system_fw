<template>
    <EventInputView v-bind:event="event" v-bind:button="button" v-bind:errors="errors" @form-submit="onSubmit" />
</template>

<script>
import Rest from "@/admin/Bits/Rest";
import { ElButton, ElMessage } from "element-plus";
import EventInputView from "../Pieces/FormInput/EventInputView.vue";
export default {
    emits: ["onCreate"],
    data: function () {
        return {
            event: {},
            button: "Create",
            showSuccess: "",
            showError: "",
            errors: [],
            visble: false,
        };
    },
    components: {
        EventInputView,
    },

    methods: {
        onSubmit() {
            const that = this;
            // console.log(that.event);
            // console.log(that.createInputForm);
            // that.createInputForm = false;

            Rest.post("inputData", that.event)
                .then((response) => {
                    that.$emit("onCreate");
                    that.event = {};
                    // that.createInputForm = false;
                    // this.$emit("onCreate", that.visble);
                    ElMessage({
                        showClose: true,
                        message: response.data.message,
                        type: "success",
                    });
                    // this.createInputForm = false;
                    // productInformation.productData = res
                    // console.log(res);
                    // this.$router.push({
                    //     name: "AllEvents",
                    // });
                })
                .catch((error) => {
                    console.log(error.responseJSON);
                    that.errors = error.responseJSON;
                });
            // EMS.adminPost({
            //     route: "create_event",
            //     ems_nonce: ajax_url.ems_nonce,
            //     data: that.event,
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
.container {
    width: 100%;
    padding: 10px;
}

.timePicker {
    margin-left: 20px;
    margin-right: 10px;
}

.box-card {
    width: 60%;
    margin: auto;
    margin-top: 50px;
}
</style>
