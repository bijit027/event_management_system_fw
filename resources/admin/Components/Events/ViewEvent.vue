<template>
    <div class="container">
        <!-- 
    <el-row>
        <el-col >
            <el-button type="primary" @click="addEvent()">Add Event</el-button>
        </el-col>
        </el-row> -->
        <!-- <div class="close_button">
        <el-button type="primary" @click="allEvents()">Back</el-button>
    </div> -->
        <div class="description">
            <el-card>
                <div class="close_button">
                    <router-link to="/" tag="button">
                        <!-- <el-icon><Back /></el-icon> -->
                        <el-button type="info">Close</el-button>
                    </router-link>
                </div>
                <div class="image">
                    <img :src="value.image" />
                </div>
                <el-descriptions title="Event Information">
                    <el-descriptions-item calss="label" label="Title:"
                        ><span class="event_value">{{ value.title }}</span></el-descriptions-item
                    >
                    <el-descriptions-item label="Details:"
                        ><span class="event_value">{{ value.details }}</span></el-descriptions-item
                    >
                    <el-descriptions-item label="Category:"
                        ><span class="event_value">{{ value.category }}</span></el-descriptions-item
                    >
                    <el-descriptions-item label="Organizer:"
                        ><span class="event_value">{{ value.organizer }}</span></el-descriptions-item
                    >
                    <el-descriptions-item label="Event Type:"
                        ><span class="event_value">{{ value.onlineEvent }}</span></el-descriptions-item
                    >
                    <el-descriptions-item label="Starting Date:"
                        ><span class="event_value">{{ value.startingDate }}</span></el-descriptions-item
                    >
                    <el-descriptions-item label="Starting Time:"
                        ><span class="event_value">{{ value.startingTime }}</span></el-descriptions-item
                    >
                    <el-descriptions-item label="Ending Date:"
                        ><span class="event_value">{{ value.endingDate }}</span></el-descriptions-item
                    >
                    <el-descriptions-item label="Ending Time:"
                        ><span class="event_value">{{ value.endingTime }}</span></el-descriptions-item
                    >
                    <el-descriptions-item label="Location:"
                        ><span class="event_value">{{ value.location }}</span></el-descriptions-item
                    >
                    <el-descriptions-item label="Limit:"
                        ><span class="event_value">{{ value.limit }}</span></el-descriptions-item
                    >
                    <el-descriptions-item label="Deadline:"
                        ><span class="event_value">{{ value.deadline }}</span></el-descriptions-item
                    >
                </el-descriptions>
                <!-- <div class="close_button">
                <router-link to="/" tag="button">

                    <el-button type="primary">Back</el-button>
                </router-link>
            </div> -->
            </el-card>
        </div>
    </div>
</template>

<script>
import Rest from "@/admin/Bits/Rest";
export default {
    data() {
        return {
            eventID: this.$route.params.eventID,
            event: {},
            value: {},
        };
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            Rest.get(`singleEventData/${this.eventID}`)
                .then((response) => {
                    this.event = response.single_event_data;
                    console.log(this.event);
                    this.value = JSON.parse(response.single_event_data.eventData);
                    // productInformation.productData = res;
                    // console.log(res.event_data);
                    // this.events = res.event_data;
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
            //     })
            //     .fail((error) => {
            //         ElMessage.error(error.responseJSON.data.error);
            //     });
        },
    },
};
</script>

<style scoped>
.time {
    font-size: 12px;
    color: #999;
}

.bottom {
    margin-top: 13px;
    line-height: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.button {
    padding: 0;
    min-height: auto;
}

.image img {
    width: 100%;
    max-height: 100%;
}

.container {
    width: 60%;
    height: 30%;
    margin: auto;
    margin-top: 50px;
}

.title {
    float: left;
}

.event_value {
    color: black;
    margin-left: auto;
}

.close_button {
    text-align: end;
    text-decoration: none;
}
</style>
