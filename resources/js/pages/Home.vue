<template>
    <!-- <div class="container h-100 d-flex justify-content-center"> -->
    <div class="my-auto">
        <h5>Welcome to Smart School</h5><br>
        <h6>Demo Accounts:</h6>
        <div class="item-list">
            <div class="item">
                <div class="item-label">
                Super admin
                </div>
                <div class="item-description">Login: superadmin@school.com <br>Password: superadmin</div>
            </div>

            <div class="item">
                <div class="item-label">
                School Admin
                </div>
                <div class="item-description">Login: schooladmin@school.com <br>Password: schooladmin</div>
            </div>

            <div class="item">
                <div class="item-label">
                Teacher
                </div>
                <div class="item-description">Login: teacher@school.com <br>Password: teacher</div>
            </div>

            <div class="item">
                <div class="item-label">
                Student
                </div>
                <div class="item-description">Login: student@school.com <br>Password: student</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Home",
    data() {
        return {
            //
        }
    },
    created() {
    },
    methods: {},
    beforeRouteEnter(to, from, next) {
        if (window.Laravel.isLoggedin) {
            return next('dashboard');
        }
        next();
    }
}
</script>
<style>
.item-list {
  position: relative;
  padding-left: 10px;
  width: 100%;
  border-left: 1px solid black;
}
.item-list .item {
  position: relative;
  line-height: 16px;
  margin-bottom: 10px;
  text-align: left;
  display: block;
  padding: 0 18px;
  font-size: 13px;
}
.item-list .item:before {
  content: "";
  position: absolute;
  top: 8px;
  left: -10px;
  width: 12px;
  height: 1px;
  background: #000;
}
.item-list .item:first-child:after {
  content: "";
  position: absolute;
  top: 0px;
  left: -12px;
  width: 5px;
  height: 8px;
  background: #fff;
}
.item-list .item:last-child:after {
  content: "";
  position: absolute;
  top: 9px;
  bottom: 0;
  left: -12px;
  width: 5px;
  background: #fff;
}
.item-list .item .item-label {
  position: relative;
  font-weight: bold;
  text-transform: uppercase;
  font-size: 13px;
  color: #0077cc;
}
.item-list .item .item-label:before {
  content: ''; 
  position: absolute;
 top: 2px;
  left: -16px;
  width: 13px;
  height: 13px;
  border-radius: 100%;
  background: #0077cc;
}
</style>