<template>
    <div class="position-relative">
        <!-- Preloader -->
        <div v-if="isLoading" class="loader-mask">
                <div class="loader">
                    <div></div>
                    <div></div>
                </div>
            </div>
        <!-- Preloader -->

        <div class="row">
            <div class="col-12 text-center" v-if="quotationCreated">
                <div class="alert alert-success" role="alert">
                    <h3 style="font-weight: bold;">A New Quotation Has Been Successfully Created !</h3>
                    <i
                        class="fas fa-times"
                        @click="quotationCreated = false"
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

            <div class="col-12 text-center" v-if="somethingWrong">
                <div class="alert alert-danger" role="alert">
                    <h3 style="font-weight: bold;">Something Went Wrong ! Please Try Again.</h3>
                    <i
                        class="fas fa-times"
                        @click="somethingWrong = false"
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

            <Stock v-if="customerTypes.length"
                :isAdmin="isAdmin"
                :clearMe="clearMe"
                :currency="currency"
                :brands="brands"
                :categories="categories"
                :baseUrl="baseUrl"
                @addStock="addStock"
                @loadStocks="loadStocks"
                :branches="branches"
                @updateBranchToEmpty="updateBranchToEmpty"
                @updateBranch="updateBranch"
                :defaultBranchId="branch_id"
                :isMultiBranchEnabled="isMultiBranchEnabled"
            />

            <div class="col-lg-5 pl-5">
                <div class="pos-card">
                    <Customer
                        :branch_id="branch_id"
                        :clearMe="clearMe"
                        :baseUrl="baseUrl"
                        @addCustomer="addCustomer"
                        :countries="countries"
                        :genders="genders"
                        :customerTypes="customerTypes"
                        :isMultiBranchEnabled="isMultiBranchEnabled"
                    />

                    <div
                        id="cart-section-2"
                        class="cart-items-wrapper h-100 custom-scrollbar"
                    >
                        <template v-if="selectedStocks.length">
                            <div
                                class="cart-item-container py-1 border-bottom"
                                v-for="(stock, index) in selectedStocks"
                                :key="index"
                            >
                                <div class="row mx-0 px-1 cart-item">
                                    <div
                                        class="col-md-6 cart-item-btn align-self-center"
                                    >
                                        <span class="align-self-center">
                                            {{ stock.title }}</span
                                        >
                                    </div>
                                    <div class="col-md-3">
                                        <div class="qty-input">
                                            <button
                                                class="qty-count qty-count--minus"
                                                data-action="minus"
                                                type="button"
                                                @click.prevent="
                                                    minusStock(stock.stock_id)
                                                "
                                            >
                                                -
                                            </button>
                                            <input
                                                class="product-qty"
                                                type="number"
                                                :value="stock.quantity"
                                                @input="
                                                    updateStock(
                                                        stock.stock_id,
                                                        $event.target.value
                                                    )
                                                "
                                            />
                                            <button
                                                class="qty-count qty-count--add"
                                                data-action="add"
                                                type="button"
                                                @click.prevent="
                                                    plusStock(stock.stock_id)
                                                "
                                            >
                                                +
                                            </button>
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-3 d-flex cart-calculatedPrice"
                                    >
                                        <div class="align-self-center">
                                            <span
                                                >{{ currency
                                                }}{{ stock.price }}</span
                                            >
                                        </div>
                                        <div class="align-self-center ml-2">
                                            <a
                                                href="#"
                                                class="text-danger"
                                                @click.prevent="removeStock(index)"
                                            >
                                                <i
                                                    class="fa-solid fa-trash-can"
                                                ></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mt-2 d-none changeQtyDiv">
                                        <div class="d-flex justify-content-center">
                                            <label class="col-sm-3 col-form-label"
                                                >Quantity:</label
                                            >
                                            <input
                                                type="number"
                                                name="quantity[]"
                                                value="1"
                                                class="form-control col-sm-4 px-1 input-qty"
                                                min="1"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div v-else class="text-center p-3">
                            <h4>Cart is empty !</h4>
                        </div>
                    </div>

                    <div id="cart-section-3" class="">
                        <div
                            class="row mx-0 px-3 py-2 font-weight-bold border-top border-bottom"
                        >
                            <div class="col-6 p-0">Sub Total</div>
                            <div class="col-6 p-0 text-right">
                                {{ currency }}{{ subtotal }}
                            </div>
                        </div>

                        <div class="row mx-0 px-3 py-2 border-bottom">
                            <div class="col-6 p-0">VAT/Tax</div>
                            <div class="col-6 p-0 text-right">
                                {{ currency }}{{ vat }}
                            </div>
                        </div>

                        <div
                            id="pop_mouse1"
                            class="row mx-0 px-3 py-2 border-bottom"
                        >
                            <div class="col-6 p-0 d-flex align-items-center">
                                Packaging Charge
                                <i
                                    @click="togglePackagingChargeEdit"
                                    style="cursor: pointer"
                                    class="fa fa-edit packaging-charge-popover ml-2"
                                ></i>
                            </div>
                            <div class="col-3 p-0">
                                <input
                                    @keyup.enter="togglePackagingChargeEdit"
                                    v-if="packagingChargeEdit"
                                    type="number"
                                    class="form-control px-1"
                                    v-model="packagingCharge"
                                    @input="updatePackagingCharge"
                                />
                            </div>
                            <div class="col-3 p-0 d-flex align-items-center">
                                <div class="amount-div">
                                    <span>
                                        {{ currency
                                        }}{{
                                            parseFloat(
                                                packagingChargeAmount
                                            ).toFixed(2)
                                        }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div
                            id="pop_mouse2"
                            class="row mx-0 px-3 py-2 border-bottom"
                        >
                            <div class="col-6 p-0 d-flex align-items-center">
                                Delivery Charge
                                <i
                                    @click="toggleDeliveryChargeEdit"
                                    style="cursor: pointer"
                                    class="fa fa-edit packaging-charge-popover ml-2"
                                ></i>
                            </div>
                            <div class="col-3 p-0">
                                <input
                                    @keyup.enter="toggleDeliveryChargeEdit"
                                    v-if="deliveryChargeEdit"
                                    type="number"
                                    class="form-control px-1"
                                    v-model="deliveryCharge"
                                    @input="updateDeliveryCharge"
                                />
                            </div>
                            <div class="col-3 p-0 d-flex align-items-center">
                                <div class="amount-div">
                                    <span>
                                        {{ currency
                                        }}{{
                                            parseFloat(
                                                deliveryChargeAmount
                                            ).toFixed(2)
                                        }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div id="pop_mouse3" class="row mx-0 px-3 py-2">
                            <div class="col-6 p-0 d-flex align-items-center">
                                Discount
                                <i
                                    @click="toggleDiscountEdit"
                                    style="cursor: pointer"
                                    class="fa fa-edit discount-on-subtotal-popover ml-2"
                                ></i>
                            </div>
                            <div class="col-3 p-0">
                                <input
                                    @keyup.enter="toggleDiscountEdit"
                                    v-if="discountEdit"
                                    type="number"
                                    class="form-control px-1"
                                    v-model="discount"
                                    @input="updateDiscount"
                                />
                            </div>
                            <div class="col-3 p-0 d-flex align-items-center">
                                <div class="amount-div">
                                    <span>
                                        {{ currency
                                        }}{{
                                            parseFloat(discountAmount).toFixed(2)
                                        }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row mx-0 px-3 py-2 border-top border-bottom">
                            <div class="col-6 p-0">
                                <span class="font-weight-bold"> Total </span>
                                <!-- <span
                                    ><span>( Tax</span>
                                    <span>Excluded )</span></span
                                > -->
                            </div>
                            <div class="col-3 p-0 text-center">
                                <div role="group" class="btn-group dropright"></div>
                            </div>
                            <div class="col-3 p-0 text-right">
                                <span>
                                    <a
                                        data-toggle="modal"
                                        data-target="#tax-edit-modal"
                                        href="#"
                                        class=""
                                    >
                                        <i
                                            class="la la-edit discount-all-item-popover"
                                        ></i>
                                    </a>
                                </span>
                                <span class="col-6 p-0 font-weight-bold text-right">
                                    {{ currency }}{{ total }}
                                </span>
                            </div>
                        </div>

                        <div class="row mx-0 px-3 py-2">
                            <div class="col-md-12 p-0">
                                <div class="">
                                    <label for="payment_note_1">Note</label>
                                    <textarea
                                        v-model="note"
                                        type="text"
                                        class="form-control"
                                        id="payment_note_1"
                                        name="payment_note_1"
                                        placeholder=""
                                    ></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 d-flex justify-content-center">
                            <button
                                :disabled="
                                    !selectedStocks.length ||
                                    !selectedCustomer.full_name
                                "
                                class="btn cart-pay-btn"
                                @click="createQuotation"
                            >
                                <i class="fa-solid fa-money-bill-1 mr-2"></i> Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <audio id="beepAudio">
                <source src="../../../audio/pos.wav" type="audio/mpeg">
                Your browser does not support the audio tag.
            </audio>

            <audio id="errorAudio">
                <source src="../../../audio/error.mp3" type="audio/mpeg">
                Your browser does not support the audio tag.
            </audio>
        </div>
    </div>
</template>

<script>
import print from "print-js";
import Stock from "../childComponents/Stock.vue";
import Customer from "../childComponents/Customer.vue";

export default {
    name: "Pos",
    components: {
        Stock,
        Customer,
    },
    data() {
        return {
            somethingWrong: false,
            selectedStocks: [],
            customerTypes: [],
            selectedCustomer: {},
            brands: [],
            branches: [],
            categories: [],
            stocks: [],
            baseUrl: window.BASE_URL,
            timeout: null,
            itemsPerPage: 10,
            page: 1,
            vatRate: 0, // 20%
            deliveryCharge: 0,
            packagingCharge: 0,
            discount: 0,
            note: "",
            quotationCreated: false,
            readyToPlaceOrder: true,
            authUserName: "",
            date: "",
            packagingChargeEdit: false,
            deliveryChargeEdit: false,
            discountEdit: false,
            currency: "",
            countries: [],
            genders: [],
            clearMe: false,
            packagingChargeAmount: 0,
            deliveryChargeAmount: 0,
            discountAmount: 0,
            branch_id: '',
            isAdmin: false,
            isLoading: true,
            isMultiBranchEnabled: ''
        };
    },

    async mounted() {
        //$('#pay').modal({backdrop: 'static', keyboard: false});
        await this.getInitialData();

        if (this.isMultiBranchEnabled == 'no') {
            this.branch_id = 1
        }

        $(this.$refs.paymentModal).on(
            "hidden.bs.modal",
            this.doSomethingOnHidden
        );
    },

    computed: {
        subtotal() {
            return this.selectedStocks
                .reduce((total, item) => total + item.price * item.quantity, 0)
                .toFixed(2);
        },

        vat() {
            return (
                parseFloat(this.subtotal) * parseFloat(this.vatRate) / 100 // ($percentage / 100) * $totalWidth;
            ).toFixed(2);
        },

        total() {
            return (
                parseFloat(this.subtotal) +
                parseFloat(this.vat) +
                this.deliveryChargeAmount +
                this.packagingChargeAmount -
                this.discountAmount
            ).toFixed(2);
        },
    },

    methods: {
        updateBranch(value) {
            this.branch_id = value;
        },

        updateBranchToEmpty() {
            this.branch_id = '';
        },

        updatePackagingCharge() {
            const parsedValue = parseFloat(this.packagingCharge);

            if (!isNaN(parsedValue) && parsedValue >= 0) {
                this.packagingChargeAmount = parsedValue;
            } else if (parsedValue < 0) {
                this.packagingCharge = 0;
                this.packagingChargeAmount = 0;
            } else {
                this.packagingChargeAmount = 0;
            }

            this.$forceUpdate();
        },

        updateDeliveryCharge() {
            // this.deliveryCharge =
            //     !isNaN(this.deliveryCharge) && this.deliveryCharge > 0
            //         ? this.deliveryCharge
            //         : 0;
            const parsedValue = parseFloat(this.deliveryCharge);

            if (!isNaN(parsedValue) && parsedValue >= 0) {
                this.deliveryChargeAmount = parsedValue;
            } else if (parsedValue < 0) {
                this.deliveryCharge = 0;
                this.deliveryChargeAmount = 0;
            } else {
                this.deliveryChargeAmount = 0;
            }

            this.$forceUpdate();
        },

        updateDiscount() {
            const parsedValue = parseFloat(this.discount);

            if (!isNaN(parsedValue) && parsedValue >= 0) {
                if (parsedValue > this.total) {
                    alert("Discount can not grater than total");
                    this.discount = 0;
                    this.discountAmount = 0;
                    return;
                }

                this.discountAmount = parsedValue;
            } else if (parsedValue < 0) {
                this.discount = 0;
                this.discountAmount = 0;
            } else {
                this.discountAmount = 0;
            }

            this.$forceUpdate();
        },

        loadStocks(stocks) {
            this.stocks = stocks;
        },

        addCustomer(value) {
            this.selectedCustomer = value;
        },

        // updatePackagingCharge() {
        //     this.packagingCharge =
        //         !isNaN(this.packagingCharge) && this.packagingCharge > 0
        //             ? this.packagingCharge
        //             : 0;
        // },

        togglePackagingChargeEdit() {
            this.packagingChargeEdit = !this.packagingChargeEdit;
        },

        toggleDeliveryChargeEdit() {
            this.deliveryChargeEdit = !this.deliveryChargeEdit;
        },

        toggleDiscountEdit() {
            this.discountEdit = !this.discountEdit;
        },

        clear() {
            (this.selectedStocks = []),
            (this.selectedCustomer = {}),
            (this.deliveryCharge = 0),
            (this.packagingCharge = 0),
            (this.discount = 0),
            (this.note = ''),
            (this.branch_id = ''),
            (this.authUserName = '');
            this.somethingWrong = false;

            if (this.isMultiBranchEnabled == 'no') {
                this.branch_id = 1;
            }
        },

        async createQuotation() {
            let data = {
                stocks: this.selectedStocks,
                customerId: this.selectedCustomer.id,
                payments: this.payments,
                total: this.total,
                subTotal: this.subtotal,
                vat: this.vat,
                discount: this.discount,
                deliveryCharge: this.deliveryCharge,
                packagingCharge: this.packagingCharge,
                note: this.note,
                branch_id: this.branch_id,
            };

            await axios
                .post(`${this.baseUrl}/quotations/create`, data)
                .then((response) => {
                    if (response.data.status == "success") {
                        this.quotationCreated = true;
                        this.clearMe = true;
                        this.clear();
                        window.scrollTo({
                            top: 0,
                            behavior: "smooth", // Optional: for smooth scrolling
                        });

                        //window.location.href = '/quotations/'+ response.data.data.id +'/show'

                        setTimeout(() => {
                            window.location.href = '/quotations/'+ response.data.data.id +'/show'
                        }, 1000);
                    }
                })
                .catch((error) => {
                    if (error?.response?.data?.status == "failed") {
                        this.somethingWrong = true;
                        this.clear();
                        this.clearMe = true;
                    }
                    // if (error?.response?.status === 422) {
                    //     this.validationErrors = error?.response?.data?.errors
                    // } else {
                    //     this.$toast.show(error?.response?.data?.message, {
                    //         type: 'error',
                    //     });
                    // }
                });
        },

        addStock(stock) {
            var tempStock = {
                product_id: stock.product_id,
                title: stock.product.title,
                stock_id: stock.id,
                quantity: 1,
                price: parseFloat(
                    stock.special_price > 0
                        ? stock.special_price
                        : stock.sale_price
                ),
            };

            var isExists = this.selectedStocks.filter(function (item) {
                return item.stock_id == stock.id;
            });

            if (isExists.length) {
                return this.selectedStocks.filter(function (item) {
                    if (item.stock_id == stock.id) {
                        if (stock.quantity <= item.quantity) {
                            document.getElementById('errorAudio').play();
                            alert("Out of stock");
                            return;
                        }

                        document.getElementById('beepAudio').play();
                        return item.quantity++;
                    }
                });
            }

            document.getElementById('beepAudio').play();
            this.selectedStocks.push(tempStock);
        },

        plusStock(stock_id) {
            var currentStock = this.stocks.filter(function (item) {
                return item.id == stock_id;
            });

            this.selectedStocks.filter(function (item) {
                if (item.stock_id == stock_id) {
                    if (currentStock[0].quantity <= item.quantity) {
                        document.getElementById('errorAudio').play();
                        alert("Out of stock");
                        return;
                    }

                    document.getElementById('beepAudio').play();
                    return item.quantity++;
                }
            });
        },

        minusStock(stock_id) {
            var currentStock = this.selectedStocks.filter(function (item) {
                return item.stock_id == stock_id;
            });

            if (currentStock[0].quantity == 1) {
                document.getElementById('errorAudio').play();
                return;
            }

            return this.selectedStocks.filter(function (item) {
                if (item.stock_id == stock_id) {
                    document.getElementById('beepAudio').play();
                    return item.quantity--;
                }
            });
        },

        updateStock(stock_id, quantity) {
            var currentStock = this.stocks.filter(function (item) {
                return item.id == stock_id;
            });

            this.selectedStocks = this.selectedStocks.map(function (item) {
                if (item.stock_id == stock_id) {
                    if (currentStock[0].quantity < quantity) {
                        document.getElementById('errorAudio').play();
                        alert("Out of stock");

                        return item;
                    } else {
                        document.getElementById('beepAudio').play();
                        item.quantity =
                            !isNaN(quantity) && quantity > 0
                                ? quantity
                                : item.quantity;
                    }
                }

                document.getElementById('errorAudio').play();
                return item;
            });
        },

        removeStock(index) {
            if (index >= 0 && index < this.selectedStocks.length) {
                this.selectedStocks.splice(index, 1);
            }
        },

        async getInitialData() {
            await axios
                .get(`${this.baseUrl}/pos/initial-data`)
                .then((response) => {
                    this.isMultiBranchEnabled = response.data.isMultiBranchEnabled ? 'yes' : 'no';
                    this.isAdmin = response.data.isAdmin;
                    this.brands = response.data.brands;
                    this.categories = response.data.categories;
                    this.paymentMethods = response.data.paymentMethods;
                    this.vatRate = response.data.vatAmount;
                    this.authUserName = response.data.authUserName;
                    this.date = response.data.date;
                    this.currency = response.data.currency;
                    this.genders = response.data.genders;
                    this.countries = response.data.countries;
                    this.customerTypes = response.data.customerTypes;
                    this.branches = response.data.branches;

                    this.isLoading = false;

                })
                .catch((error) => {
                    this.isLoading = false;
                });
        },
    },
};
</script>

<style scoped>
.cart-items-wrapper {
    max-height: 40vh;
    min-height: 40vh;
    overflow-x: hidden;
    overflow-y: scroll;
}

.loader-mask {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #fff;
    z-index: 99999;
}

.loader {
    position: absolute;
    left: 50%;
    top: 50%;
    width: 50px;
    height: 50px;
    font-size: 0;
    color: #00c9d0;
    display: inline-block;
    margin: -25px 0 0 -25px;
    text-indent: -9999em;
    -webkit-transform: translateZ(0);
    -ms-transform: translateZ(0);
    transform: translateZ(0);
}
.lead{
  font-size:13px;
}
.loader div {
    background-color: #d9b06a;
    display: inline-block;
    float: none;
    position: absolute;
    top: 0;
    left: 0;
    width: 50px;
    height: 50px;
    opacity: .5;
    border-radius: 50%;
    -webkit-animation: ballPulseDouble 2s ease-in-out infinite;
    animation: ballPulseDouble 2s ease-in-out infinite;
}

.loader div:last-child {
    -webkit-animation-delay: -1s;
    animation-delay: -1s;
}

@-webkit-keyframes ballPulseDouble {
    0%,
    100% {
        -webkit-transform: scale(0);
        transform: scale(0);
    }
    50% {
        -webkit-transform: scale(1);
        transform: scale(1);
    }
}

@keyframes ballPulseDouble {
    0%,
    100% {
        -webkit-transform: scale(0);
        transform: scale(0);
    }
    50% {
        -webkit-transform: scale(1);
        transform: scale(1);
    }
}
</style>
