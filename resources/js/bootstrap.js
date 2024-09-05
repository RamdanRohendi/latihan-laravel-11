import axios from 'axios';
import $ from 'jquery';
import Swal from 'sweetalert2';
import DataTable from 'datatables.net-dt';

window.axios = axios;
window.$ = $;
window.Swal = Swal;
window.DataTable = DataTable;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
