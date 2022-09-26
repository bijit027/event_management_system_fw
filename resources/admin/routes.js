import Dashboard from './Components/Dashboard.vue';
import AddEvent from "./Components/Events/AddEvent.vue";
import AllEvents from "./Components/Events/AllEvents.vue";
import ViewEvent from "./Components/Events/ViewEvent.vue";
import EditEvent from "./Components/Events/EditEvent.vue";

export default [
    {
        path: '/',
        name: 'AllEvents',
        component: AllEvents,
        meta: {
            active: 'AllEvents'
        }
    },
    {
        path: '/addEvent',
        name: 'AddEvent',
        component: AddEvent,
    },
    {
        path: "/show-event/:eventID",
        name: "ViewEvent",
        component: ViewEvent,
    },
    {
        path: "/edit-event/:eventID",
        name: "EditEvent",
        component: EditEvent,
    },

];

