<template>
    <div class="dashboard box_wrapper">
        <div class="box dashboard_box box_narrow">
            <div class="box_header" style="padding: 20px 15px; font-size: 16px">
                Good {{ greetingTime }} {{ me.full_name }}!asdads {{ welcome }}
            </div>
        </div>
        <pre>{{ restaurant.name }}</pre>
        <form action="" class="add">
            <input type="text" placeholder="Restaurant Name" v-model="restaurant.name" name="name" />
            <input type="text" placeholder="Enter Address" v-model="restaurant.address" name="address" />
            <input type="text" placeholder="Enter Contact" v-model="restaurant.contact" name="contact" />
            <button type="button" @click="sendData">Add New Restaurant</button>
        </form>
    </div>
</template>

<script>
import Rest from "@/admin/Bits/Rest";
export default {
    name: "Dashboard",
    data() {
        return {
            me: this.appVars.me,
            welcome: "",
            restaurant: {
                name: "",
                address: "",
                contact: "",
            },
        };
    },
    methods: {
        dd() {
            // this.$get("welcome");

            Rest.get("welcome")
                .then((res) => {
                    // productInformation.productData = res
                    console.log(res);
                })
                .catch((err) => console.log(err));

            // console.log(this.$get("welcome"));
        },

        sendData() {
            console.log(this.restaurant);
            const data = {
                store_id: "1",
                brand: "apple",
                model: "lk",
                price: "5",
                description: "jhfuhfhgfy",
            };
            Rest.post("inputData", data);
        },
    },
    mounted() {
        this.dd();
    },
    computed: {
        greetingTime() {
            const m = this.moment();
            let g = null; //return g

            if (!m || !m.isValid()) {
                return;
            } //if we can't find a valid or filled moment, we return.

            const split_afternoon = 12; //24hr time to split the afternoon
            const split_evening = 17; //24hr time to split the evening
            const currentHour = parseFloat(m.format("HH"));

            if (currentHour >= split_afternoon && currentHour <= split_evening) {
                g = "afternoon";
            } else if (currentHour >= split_evening) {
                g = "evening";
            } else {
                g = "morning";
            }

            return g;
        },
    },
};
</script>
