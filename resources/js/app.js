// resources/js/app.js
import { createApp } from 'vue';

// المسارات الصحيحة
import RecentActivities from './components/Admin/RecentActivities.vue';
import StatsDashboard from './components/Admin/StatsDashboard.vue';
import AidRequestForm from './components/Beneficiary/AidRequestForm.vue';
import RequestHistory from './components/Beneficiary/RequestHistory.vue';
import FileUpload from './components/Shared/FileUpload.vue';
import NotificationToast from './components/Shared/NotificationToast.vue';
import StatusBadge from './components/Shared/StatusBadge.vue';
import Alert from './components/UI/Alert.vue';
import Modal from './components/UI/Modal.vue';
import DistributionList from './components/Volunteer/DistributionList.vue';
import DistributionStatus from './components/Volunteer/DistributionStatus.vue';

const app = createApp({});

// تسجيل المكونات
app.component('recent-activities', RecentActivities);
app.component('stats-dashboard', StatsDashboard);
app.component('aid-request-form', AidRequestForm);
app.component('request-history', RequestHistory);
app.component('file-upload', FileUpload);
app.component('notification-toast', NotificationToast);
app.component('status-badge', StatusBadge);
app.component('alert-box', Alert);
app.component('modal-dialog', Modal);
app.component('distribution-list', DistributionList);
app.component('distribution-status', DistributionStatus);

app.mount('#app');
