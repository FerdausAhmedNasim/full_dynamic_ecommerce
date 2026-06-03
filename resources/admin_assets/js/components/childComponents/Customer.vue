<template>
    <div class="sales-search border-bottom">
        <div class="row mb-2">
            <div class="col-11">
                <div v-if="customerSearchBox" class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa-solid fa-user"></i>
                        </span>
                    </div>
                    <input
                        type="text"
                        placeholder="Search Customers"
                        aria-label="Search"
                        aria-describedby="search"
                        class="form-control rounded-right"
                        v-model="searchCustomer"
                    />
                    <div v-if="customerSearchResultClearIcon">
                        <i style="cursor: pointer;" @click="searchCustomer = ''"
                            class="fa fa-close position-absolute p-1 customer-search-cancel"
                        ></i>
                    </div>

                    <div
                        v-if="
                            searchCustomer.length >= 2 && customers.length
                        "
                        class="dropdown-menu dropdown-menu-right w-100 show"
                    >
                        <div
                            v-if="customers.length"
                            class="customers-container"
                        >
                            <span
                                v-for="(
                                    customer, index
                                ) in customers"
                                :key="index"
                                ><a
                                    @click.prevent="
                                        selectCustomer(customer)
                                    "
                                    href="#"
                                    class="dropdown-item active"
                                    ><h6 class="m-0">
                                        {{ customer.full_name }}
                                        <br />
                                        <small
                                            ><i
                                                class="fa fa-envelope"
                                            ></i>
                                            {{
                                                customer.email
                                            }}</small
                                        >
                                        <small style="padding-left: 5px;"
                                            ><i
                                                class="fa fa-phone-square"
                                            ></i>
                                            {{
                                                customer.phone
                                            }}</small
                                        >
                                    </h6></a
                                >
                                <div
                                    class="dropdown-divider m-0"
                                ></div
                            ></span>
                        </div>
                    </div>

                    <div
                        v-else-if="
                            searchCustomer.length >= 2 && !customers.length
                        "
                        class="dropdown-menu dropdown-menu-right w-100 show"
                    >
                        No customer found
                    </div>
                </div>

                <div v-if="selectedCustomer.full_name">
                    <div class="p-2">
                        <h6
                            class="m-0 cart-product-details-parent d-flex justify-content-between"
                        >
                            <div class="cart-product-details-child">
                                {{ selectedCustomer.full_name }}
                                <br />
                                <small
                                    ><i class="la la-envelope"></i>
                                    {{ selectedCustomer.email }}</small
                                >
                                <small
                                    ><i class="la la-phone-square"></i>
                                    {{ selectedCustomer.phone }}</small
                                >
                            </div>
                            <div v-if="dueAmount">
                                <span class="text-danger">Due Amount: {{ dueAmount }}</span>
                            </div>
                            <a
                                href="#"
                                @click="showCustomerSearchBox"
                                class="cart-product-details-child text-right"
                                ><i class="fa fa-close"></i
                            ></a>
                        </h6>
                    </div>
                </div>

            </div>
            <!---->
            <div class="col-1">
                <span style="position: absolute; left: 0;" class="customer-toltip">
                    <a
                        data-toggle="modal"
                        data-target="#customer-add-edit-modal"
                        href="#"
                        class="btn btn2-secondary btn-customer-add"
                    >
                        <i class="fa-solid fa-user-plus"></i>
                        <span class="tooltiptext">Add New  Customer</span>
                    </a>
                </span>
            </div>
        </div>

        <!-- customer modal -->
        <div ref="customerModal" class="modal fade" id="customer-add-edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                <i class="fa-solid fa-user-plus text-primary"></i>
                                Add Customer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 text-center " v-if="customerAdded">
                                    <div class="alert alert-success" role="alert">
                                        <h3 style="font-weight: bold;">A New Customer Successfully Added !</h3>
                                    <i
                                        class="fas fa-times"
                                        @click="customerAdded = false"
                                        style="
                                            font-size: 16px;
                                            position: absolute;
                                            right: 0;
                                            top: 42%;
                                            cursor: pointer;
                                        "
                                    ></i>
                                    </div>
                                </div>

                                <div class="col-12 text-center " v-if="somethingWrong">
                                    <div class="alert alert-danger" role="alert">
                                        <h3 style="font-weight: bold;">Something Went Wrong ! Please Try Again.</h3>
                                    <i
                                        class="fas fa-times"
                                        @click="clearErrorMessage"
                                        style="
                                            font-size: 16px;
                                            position: absolute;
                                            right: 0;
                                            top: 42%;
                                            cursor: pointer;
                                        "
                                    ></i>
                                    </div>
                                </div>

                                    <div class="col-md-10" v-if="customerTypes.length">
                                        <div class="p-sm-3 row"><label class="col-md-3 col-form-label required">Customer Type</label>
                                            <div class="col-md-9">
                                                <div class="selector">
                                                    <label v-for="(customerType, index) in customerTypes" :key="index">
                                                        <input class="" type="radio" v-model="newCustomer.customer_type" :value="customerType">
                                                        {{ customerType }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <div class="col-md-6">
                                    <div class="p-sm-3">

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label required">Full Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" v-model="newCustomer.full_name"
                                                    placeholder="Full Name"
                                                    required>
                                                    <p v-if="validationErrors.full_name" class="text-danger">{{ validationErrors?.full_name[0] }}</p>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Email</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" v-model="newCustomer.email"
                                                    placeholder="example@example.com">

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" for="name">Gender</label>
                                            <div class="col-sm-9">
                                                <select class="select form-control" v-model="newCustomer.gender" id="gender"
                                                    style="width: 100%;">
                                                    <option value="" selected disabled>Select One</option>
                                                    <option v-for="(gender, index) in genders" :value="gender" :key="index">{{ gender }}</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Address</label>
                                        <div class="col-sm-9">
                                            <textarea type="text" class="form-control" v-model="newCustomer.address"
                                                placeholder="Address"
                                                ></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Description</label>
                                        <div class="col-sm-9">
                                            <textarea type="text" class="form-control" v-model="newCustomer.description"
                                                placeholder="Description"
                                                ></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label required">Mobile No</label>
                                        <div class="col-sm-9">
                                            <div class="input-group mb-4">
                                                <!-- <div class="input-group-prepend">
                                                <select class="input-group-text text-secondary" v-model="newCustomer.country_code">
                                                        <option v-for="(country, index) in countries" :key="index" :value="country.code" >{{ country.code }}</option>
                                                </select>
                                                </div> -->
                                                <input type="number" min="0" v-model="newCustomer.phone" class="form-control" placeholder="013 355 666">
                                            </div>
                                            <p v-if="validationErrors.phone" class="text-danger">{{ validationErrors.phone[0] }}</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn2-light-secondary mr-3" data-dismiss="modal"><i
                                class="fas fa-times"></i> Close</button>
                                <button @click.prevent="addNewCustomer" type="submit" class="btn mr-3 my-3 btn2-secondary submitBtn"><i class="fas fa-save"></i> Save</button>

                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Stock",
    props: ['baseUrl', 'countries', 'genders', 'clearMe', 'customerTypes'],
    data() {
        return {
            searchCustomer: '',
            newCustomer: {
                full_name: '',
                email: '',
                gender:  '',
                address: '',
                description: '',
                phone: '',
                customer_type: 'individual'
            },
            customerSearchBox: true,
            customerDetails: false,
            customerSearchResult: false,
            customerSearchResultClearIcon: false,
            customers: [],
            selectedCustomer: {},
            validationErrors: {},
            customerAdded: false,
            somethingWrong: false,
            timeout: null,
            itemsPerPage: 10,
            page: 1,
            dueAmount: 0,
        }
    },

    watch: {
        options: {
            handler() {
                this.getCustomers();
            },
            deep: true,
        },

        clearMe(value, oldVal) {
            this.clear();
        },

        // branch_id(value, oldVal) {
        //     if (value && this.selectedCustomer.id) {
        //         this.getDeuAmount();
        //     }
        // },

        searchCustomer(value, oldVal) {
            if (value.length) {
                this.customerSearchResultClearIcon = true;
            } else {
                this.customerSearchResultClearIcon = false;
            }

            if (value.length >= 2 || oldVal.length >= 2) {
                if (this.timeout) {
                    clearTimeout(this.timeout);
                }
                this.timeout = setTimeout(() => {
                    this.getCustomers();
                }, 500);
            }
        }
    },

    async mounted() {
        await this.getCustomers();

        $(this.$refs.customerModal).on(
            "hidden.bs.modal",
            this.closingCustomerModal,
        );
    },

    methods: {
        clearErrorMessage() {
            this.somethingWrong = false;
            this.validationErrors = {};
        },

        clear() {
            this.selectedCustomer = {};
            this.customerSearchBox = true;
        },

        async getCustomers() {
            await axios
                .get(
                    `${this.baseUrl}/pos/customers?per_page=${this.itemsPerPage}&page=${this.page}&search=${this.searchCustomer}`
                )
                .then((response) => {
                    this.page = response.data.data.current_page;
                    this.customers = response.data.data.data;
                })
                .catch((error) => {
                    //
                });
        },

        async addNewCustomer() {
            await axios
            .post(`${this.baseUrl}/pos/customer`, this.newCustomer)
            .then((response) => {
                if (response.data.status == "success") {
                    this.customerAdded = true;
                    this.newCustomer = {};
                    this.validationErrors = {},
                    this.newCustomer.customer_type = 'individual';
                }
            })
            .catch((error) => {
                if (error?.response?.status === 422) {
                    this.validationErrors = error?.response?.data?.errors
                } else {
                    this.somethingWrong = true;
                }
            });
        },

        async getDeuAmount() {
            await axios
                .get(
                    `${this.baseUrl}/pos/customers/${this.selectedCustomer.id}/due`
                )
                .then((response) => {
                    this.dueAmount = response.data.dueAmount;
                })
                .catch((error) => {
                    //
                });
        },

        showCustomerSearchBox() {
            this.customerSearchBox = true;
            this.selectedCustomer = {};
        },

        selectCustomer(customer) {
            this.customerSearchBox = false;
            this.searchCustomer = "";
            this.selectedCustomer = customer;
            this.$emit('addCustomer', customer);
            this.getDeuAmount();
        },

        closingCustomerModal() {
            this.validationErrors = {};
            this.customerAddedMessage = '';
            this.newCustomer.customer_type = 'individual';
        },
    }
}
</script>

<style scoped>
        .customer-toltip .tooltiptext {
            visibility: hidden;
            width: 100px;
            background-color: #0dbb62;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 7px 10px;
            position: absolute;
            z-index: 1;
            bottom: 50px;
            left: calc(15% - 35px);
        }

        .customer-toltip .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #0dbb62 transparent transparent transparent;
        }

        .customer-toltip:hover .tooltiptext {
            visibility: visible;
        }

        .customers-container {
            margin: 0px 10px;
        }

        .dropdown-item.active, .dropdown-item:active {
            padding: 5px 15px;
            background-color: #61d399;
        }

        .dropdown-item.active h6 {
            font-size: 18px;
        }
</style>
