import Vue from "vue";
import VueRouter from "vue-router";
import About from "../components/pages/about";
import HomeComponent from "../components/pages/homeComponent";
import IndicatorComponent from "@/components/pages/indicatorCompanent";
import Registration from "@/components/pages/users/registration";
import productComponent from "@/components/pages/productComponent";
import Career from "@/components/pages/career";
import Contact from "@/components/pages/contact";
import UserLogin from "@/components/pages/users/userLogin";
import ForgotPassword from "@/components/pages/users/forgotPassword";
import RegistrationSuccess from "@/components/pages/users/registrationSuccess";
import MyAccount from "@/components/pages/users/myAccount";
import DoPayment from "@/components/pages/users/doPayment";
import paymentSuccess from "@/components/pages/users/paymentSuccess";
import ForgotPasswordSuccess from "@/components/pages/users/forgotPasswordSuccess";
import HelpDesk from "@/components/pages/users/helpDesk";
import CancelSubscription from "@/components/pages/users/cancelSubscription";
import Archive from "@/components/pages/users/archive";
// import MyCharts from "@/components/pages/users/myCharts";
import Offerings from "@/components/pages/offerings";
Vue.use(VueRouter);
const vueRouter = new VueRouter({
  routes: [
    {
      path: "/",
      name: "Home",
      component: HomeComponent
    },
    {
      path: "/about",
      name: "About us",
      component: About
    },
    {
      path: "/indicator",
      name: "Indicator pages",
      component: IndicatorComponent
    },
    {
      path: "/registration",
      name: "Registration",
      component: Registration
    },
    {
      path: "/product",
      name: "Product",
      component: productComponent
    },
    {
      path: "/career",
      name: "Career",
      component: Career
    },
    {
      path: "/contact",
      name: "Contact",
      component: Contact
    },
    {
      path: "/login",
      name: "User Login",
      component: UserLogin
    },
    {
      path: "/forgot_password",
      name: "Forgot Password",
      component: ForgotPassword
    },
    {
      path: "/registration_success",
      name: "Registration Success",
      component: RegistrationSuccess
    },
    {
      path: "/my_account",
      name: "User Profile",
      component: MyAccount
    },
    {
      path: "/do_payment",
      name: "Payment Aggrement",
      component: DoPayment
    },
    {
      path: "/payment_success",
      name: "Payment Success",
      component: paymentSuccess
    },
    {
      path: "/forgot_password_success",
      name: "Forgot Password Success",
      component: ForgotPasswordSuccess
    },
    {
      path: "/help_desk",
      name: "Help Desk",
      component: HelpDesk
    },
    {
      path: "/cancel_subscription",
      name: "Cancel Subscription",
      component: CancelSubscription
    },
    {
      path: "/archive",
      name: "Archive Page",
      component: Archive
    },
    // {
    //   path: "/my_chart",
    //   name: "My Charts",
    //   component: MyCharts
    // },
    {
      path: "/offerings",
      name: "Our Offers",
      component: Offerings
    }
  ],
  mode: "history"
});
export default vueRouter;
