import { createRouter, createWebHistory } from 'vue-router'
import Dashboard from '../views/Dashboard.vue'
import SampleList from '../views/samples/SampleList.vue'
import ManufacturerList from '../views/manufacturers/ManufacturerList.vue'
import ProductList from '../views/products/ProductList.vue'
import UnitList from '../views/units/UnitList.vue';
import ParameterList from '../views/parameters/ParameterList.vue';
import OfficeList from '../views/offices/OfficeList.vue';
import TestList from '../views/tests/TestList.vue';
import LabList from '../views/labs/LabList.vue';
import ScanMode from '../views/ScanMode.vue';


const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', name: 'dashboard', component: Dashboard },
    { path: '/offices', name: 'offices', component: OfficeList },
    { path: '/labs', name: 'labs', component: LabList },
    { path: '/tests', name: 'tests', component: TestList },
    { path: '/units', name: 'units', component: UnitList },
    { path: '/parameters', name: 'parameters', component: ParameterList },
    { path: '/manufacturers', name: 'manufacturers', component: ManufacturerList },
    { path: '/products', name: 'products', component: ProductList },
    { path: '/samples', name: 'samples', component: SampleList },
    { path: '/scan', name: 'scan', component: ScanMode },
    {
      path: '/verify/:id',
      name: 'public-verify',
      // Dynamic import (Lazy Loading)
      component: () => import('../views/public/VerifyReport.vue'),
      meta: { public: true }
    }

  ]
})

export default router
