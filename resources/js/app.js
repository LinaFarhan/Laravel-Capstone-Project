import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
 
// Import components
import StatsDashboard from './components/Admin/StatsDashboard.vue'
import RecentActivities from './components/Admin/RecentActivities.vue'
import DistributionList from './components/Volunteer/DistributionList.vue'
import DistributionStatus from './components/Volunteer/DistributionStatus.vue'
import AidRequestForm from './components/Beneficiary/AidRequestForm.vue'
import RequestHistory from './components/Beneficiary/RequestHistory.vue'
import NotificationToast from './components/Shared/NotificationToast.vue'
import FileUpload from './components/Shared/FileUpload.vue'
import StatusBadge from './components/Shared/StatusBadge.vue'
import Modal from './components/UI/Modal.vue'
import Alert from './components/UI/Alert.vue'

const app = createApp({});
const pinia = createPinia();

app.use(pinia);
 
// Register global components
app.component('StatsDashboard', StatsDashboard)
app.component('RecentActivities', RecentActivities)
app.component('DistributionList', DistributionList)
app.component('DistributionStatus', DistributionStatus)
app.component('AidRequestForm', AidRequestForm)
app.component('RequestHistory', RequestHistory)
app.component('NotificationToast', NotificationToast)
app.component('FileUpload', FileUpload)
app.component('StatusBadge', StatusBadge)
app.component('Modal', Modal)
app.component('Alert', Alert)

app.mount('#app')