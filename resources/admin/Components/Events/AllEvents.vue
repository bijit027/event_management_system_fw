<template>
    <el-main>
        <!--start-->
        <!-- <template>
            <el-button text @click="outerVisible = true">open the outer Dialog</el-button>

            <el-dialog v-model="outerVisible" title="Outer Dialog">
                <template #default>
                    <el-dialog v-model="innerVisible" width="30%" title="Inner Dialog" append-to-body />
                </template>
                <template #footer>
                    <div class="dialog-footer">
                        <el-button @click="outerVisible = false">Cancel</el-button>
                        <el-button type="primary" @click="innerVisible = true">open the inner Dialog</el-button>
                    </div>
                </template>
            </el-dialog>
        </template> -->
        <el-dialog v-model="AddEventFormVisible" title="Event Form">
            <!-- <AddEvent :createInputForm="createInputForm" @onCreate="modalVisble" /> -->
            <AddEvent @onCreate="modalVisble" />
        </el-dialog>
        <!--View edit modal-->
        <el-dialog v-model="EditEventFormVisible" title="Edit Event" :show-close="false">
            <div class="modal_button">
                <el-button class="close_button" type="danger" size="small" @click="closeEditModal()">
                    <el-icon class="el-icon--left"><CircleCloseFilled /></el-icon>
                    Close
                </el-button>
            </div>

            <!-- <AddEvent :createInputForm="createInputForm" @onCreate="modalVisble" /> -->
            <EditEvent :eventID="eventID" @onCreate="modalVisble" />
        </el-dialog>

        <!--end-->
        <el-row>
            <div class="ems_header event_wraper">
                <h1 class="event_title">ALL Events</h1>
                <div class="event_actions">
                    <span class="tooltip-text">
                        <el-button size="small" @click="copyShortcode(index)" :icon="CopyDocument" text>
                            <code class="copy" :data-clipboard-text="`[event-management]`">
                                Use this shortcode [event-management]
                            </code>
                        </el-button>
                    </span>
                    <el-button type="primary" size="small" @click="addEvent()">Add Event</el-button>
                    <!-- <el-button class="payform_action" @click="createFormModal = true" size="small" type="primary">
                       Add Event
                    </el-button> -->
                </div>
            </div>

            <el-table :data="displayData" style="width: 100%" border>
                <el-table-column label="ID" prop="ID" width="60" />
                <el-table-column label="Event" prop="post_title" />
                <el-table-column label="Date" prop="post_date" width="160" />
                <el-table-column label="Operations" width="250">
                    <template #default="scope">
                        <el-button size="small" type="primary" @click="showSingleData(scope.$index, scope.row)"
                            >View</el-button
                        >
                        <el-button size="small" @click="editEventData(scope.$index, scope.row)">Edit</el-button>
                        <el-button size="small" type="danger" @click="confirmDeleteMessage(scope.row)"
                            >Delete</el-button
                        >
                    </template>
                </el-table-column>
            </el-table>
        </el-row>
        <el-row v-if="events.length > 10">
            <div class="pagination-block">
                <el-pagination
                    background
                    layout="total,sizes,prev, pager, next,jumper"
                    @current-change="handleCurrentChange"
                    @size-change="handleSizeChange"
                    :page-size="pageSize"
                    :page-sizes="[10, 20, 30, 40]"
                    :total="events.length"
                />
            </div>
        </el-row>

        <!--Delete event Confimation Modal-->
        <el-dialog
            title="Are You Sure, You want to delete this event?"
            v-model="deleteDialogVisible"
            :show-close="false"
            width="40%"
        >
            <div class="modal_body">
                <p>Event ID: {{ deleteingForm.ID }}?</p>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button type="danger" @click="deleteDialogVisible = false">Cancel</el-button>
                <el-button type="primary" @click="deletEvent(deleteingForm.ID)">Confirm</el-button>
            </span>
        </el-dialog>
    </el-main>
</template>

<script>
import AddEvent from "./AddEvent.vue";
import EditEvent from "./EditEvent.vue";
import Rest from "@/admin/Bits/Rest";
import { CircleCloseFilled } from "@element-plus/icons-vue";
// import Clipboard from "clipboard";
import { ElButton, ElMessage } from "element-plus";
import { ElNotification } from "element-plus";
import Clipboard from "clipboard";
export default {
    components: {
        ElButton,
    },
    data() {
        return {
            AddEventFormVisible: false,
            EditEventFormVisible: false,
            loading: false,
            events: [],
            errorMessage: null,
            showSuccess: "",
            showError: "",
            page: 1,
            pageSize: 10,
            deleteingForm: {},
            deleteDialogVisible: false,
            eventID: "",
        };
    },
    components: {
        AddEvent,
        EditEvent,
    },

    mounted() {
        this.fetchData();
        // var clipboard = new Clipboard(".copy");
        // clipboard.on("success", (e) => {
        //     this.$message({
        //         message: "Copied to Clipboard!",
        //         type: "success",
        //     });
        // });
    },
    computed: {
        displayData() {
            if (!this.events || this.events.length === 0) return [];
            return this.events.slice(this.pageSize * this.page - this.pageSize, this.pageSize * this.page);
        },
    },
    methods: {
        closeEditModal() {
            this.EditEventFormVisible = false;
        },
        modalVisble() {
            this.AddEventFormVisible = false;
            this.fetchData();
            console.log(this.AddEventFormVisible);
        },
        handleCurrentChange(val) {
            this.page = val;
        },
        handleSizeChange(val) {
            this.pageSize = val;
        },
        confirmDeleteMessage(form) {
            this.deleteingForm = form;
            this.deleteDialogVisible = true;
        },

        addEvent() {
            this.AddEventFormVisible = true;
            // this.$router.push({
            //     path: `/addEvent`,
            // });
        },
        editEventData(index, row) {
            this.eventID = row.ID;
            this.EditEventFormVisible = true;
            // this.$router.push({
            //     path: `/edit-event/${row.ID}`,
            // });
        },
        deletEvent(id) {
            Rest.delete(`deleteEvent/${id}`, {
                id,
            })
                .then((response) => {
                    // consol.log(res);
                    this.fetchData();
                    this.deleteDialogVisible = false;
                    // ElMessage({
                    //     showClose: true,
                    //     message: res.message,
                    //     type: "success",
                    // });
                    ElNotification({
                        title: "Success",
                        message: response.message,
                        type: "success",
                        position: "bottom-right",
                        duration: 2000,
                    });

                    // if (res.status === 200) {
                    //     ElNotification({
                    //         title: "Success",
                    //         message: "Successfully deleted the genre",
                    //         type: "success",
                    //         position: "bottom-right",
                    //         duration: 2000,
                    //     });
                    //     setTimeout(function () {
                    //         this.fetchData();
                    //     }, 2000);
                    // }
                })
                .catch((xhr, ajaxOptions, thrownError) => {
                    ElNotification({
                        title: "Error",
                        message: thrownError,
                        type: "error",
                        position: "bottom-right",
                        duration: 2000,
                    });
                })
                .always(() => {});
            // const that = this;
            // EMS.adminPost({
            //         route: 'delete_event',
            //         id: id,
            //         ems_nonce: ajax_url.ems_nonce,
            //     })
            //     .then(response => {
            //         this.fetchData();
            //         ElMessage({
            //             showClose: true,
            //             message: response.data.message,
            //             type: 'success',
            //         })
            //         this.deleteDialogVisible = false;
            //     })
            //     .fail(error => {
            //         ElMessage.error(error.responseJSON.data.error);
            //         this.deleteDialogVisible = false;
            //     })
        },
        showSingleData(index, row) {
            this.$router.push({
                path: `/show-event/${row.ID}`,
            });
        },
        copyShortcode() {
            var clipboard = new Clipboard(".copy");
            clipboard.on("success", (e) => {
                this.$message({
                    message: "Copied to Clipboard!",
                    type: "success",
                });
            });
        },
        fetchData() {
            Rest.get("eventData")
                .then((res) => {
                    // productInformation.productData = res
                    console.log(res.event_data);
                    this.events = res.event_data;
                })
                .catch((err) => console.log(err));
            // const that = this;
            // EMS.adminGet({
            //     route: "get_event_data",
            //     ems_nonce: ajax_url.ems_nonce,
            //     category: "",
            // })
            //     .then((response) => {
            //         that.events = response.data.event_data;
            //     })
            //     .fail((error) => {
            //         ElMessage.error(error.responseJSON.data.error);
            //     });
        },
    },
};
</script>

<style>
.pagination-block {
    margin-left: auto;
    margin-right: 0px;
    margin-top: 20px;
}

.el-button {
    margin-bottom: 10px;
}

.message {
    background-color: white;
    border: 1px solid black;
    display: inline;
    margin-left: 40px;
}

.ems_header.event_wraper {
    border-bottom: 0;
    margin: 0px;
    padding: 10px 20px;
    width: 100%;
    background-color: aliceblue;
}

.event_title {
    float: left;
    margin: 0;
    padding: 0;
}

.event_actions {
    float: right;
    text-align: right;
}

.tooltip-text {
    margin-right: 10px;
}
.close_button {
    float: right;
}
.modal_button {
    width: 100%;
    overflow: hidden;
}
</style>
