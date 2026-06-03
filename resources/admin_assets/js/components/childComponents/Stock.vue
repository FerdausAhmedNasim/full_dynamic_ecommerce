<template>
    <div class="col-lg-7">
        <div class="pos-card mb-3">
            <div class="row mx-0">
                <div class="px-0 mb-2 mb-md-0 col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                        </div>
                        <input
                            type="text"
                            placeholder="Search Product"
                            aria-label="Search"
                            id="search"
                            aria-describedby="search"
                            class="form-control pr-4 rounded-right"
                            v-model="searchProduct"
                        />

                        <div
                            v-if="productSearchResultClearIcon"
                            @click="searchProduct = ''"
                        >
                            <i
                                style="cursor: pointer"
                                class="fa fa-close position-absolute p-1 customer-search-cancel"
                            ></i>
                        </div>
                    </div>
                </div>


                <div class="col-md-3 px-0 pl-md-2">
                    <div
                        class="language"
                        :class="brandDrawer ? 'highlight' : ''"
                        @click="toggleBrandDrawer"
                    >
                        <p class="language-copy">Select Brand</p>
                        <i
                            class="icon fas fa-chevron-down"
                            :style="{
                                transform: brandDrawer
                                    ? 'rotate(180deg)'
                                    : '',
                            }"
                        ></i>
                    </div>
                    <transition name="slide" style="z-index: 999">
                        <div class="language-drawer" v-if="brandDrawer">
                            <ul
                                v-if="brands.length"
                                class="drawer-list custom-scrollbar"
                            >
                                <li
                                    class="drawer-list-item"
                                    v-for="(brand, index) in brands"
                                    :key="index"
                                >
                                    <div class="drawer-list-name">
                                        <input
                                            type="checkbox"
                                            v-model="selectedBrands"
                                            :id="index"
                                            :value="brand.id"
                                        />
                                        <label class="my-0" :for="index">
                                            {{ brand.languages[0].title }}
                                        </label>
                                    </div>
                                    <!-- <p class="drawer-list-value">{{ entry.value }}</p> -->
                                </li>
                            </ul> <hr>

                            <div
                                class="d-flex justify-content-between align-items-center filter-footer"
                            >
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary btn-sm"
                                    @click="clearBrandDrawer"
                                >
                                    Clear
                                </button>
                                <button
                                    @click="brandDrawer = false"
                                    type="button"
                                    class="btn btn-success btn-sm"
                                >
                                    Close
                                </button>
                            </div>
                        </div>
                    </transition>
                </div>

                <div class="col-md-3 px-0 pl-md-2">
                    <div
                        class="language"
                        :class="categoryDrawer ? 'highlight' : ''"
                        @click="toggleCategoryDrawer"
                    >
                        <p class="language-copy">Select Category</p>
                        <i
                            class="icon fas fa-chevron-down"
                            :style="{
                                transform: categoryDrawer
                                    ? 'rotate(180deg)'
                                    : '',
                            }"
                        ></i>
                    </div>
                    <transition name="slide" style="z-index: 999">
                        <div class="language-drawer" v-if="categoryDrawer">
                            <ul
                                v-if="categories.length"
                                class="drawer-list custom-scrollbar"
                            >
                                <li
                                    class="drawer-list-item"
                                    v-for="(category, index) in categories"
                                    :key="index"
                                >
                                    <div class="drawer-list-name">
                                        <input
                                            type="checkbox"
                                            v-model="selectedCategories"
                                            :id="category.name"
                                            :value="category.id"
                                        />
                                        <label class="my-0" :for="category.name" >
                                            {{ category.languages[0].title }}
                                        </label
                                        >
                                    </div>
                                    <!-- <p class="drawer-list-value">{{ entry.value }}</p> -->
                                </li>
                            </ul> <hr>

                            <div
                                class="d-flex justify-content-between align-items-center filter-footer"
                            >
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary btn-sm"
                                    @click="clearCategoryDrawer"
                                >
                                    Clear
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-success btn-sm"
                                    @click="categoryDrawer = false"
                                >
                                    Close
                                </button>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </div>
        
        <div class="product-section custom-scrollbar position-relative">
            <!-- Preloader -->
                <div v-if="isLoading" class="loader-mask">
                    <div class="loader">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            <!-- Preloader -->

            <div class="row" v-if="products.length">
                <div
                    v-for="(product, index) in products"
                    :key="index"
                    class="col-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 mb-75 px-2 standard-product"
                >
                    <a
                        href="#"
                        data-toggle="modal"
                        class="app-color-text"
                        @click.prevent="handleProductClick(product)"
                    >
                    <!-- <a
                        href="#"
                        data-toggle="modal"
                        class="app-color-text"
                        @click.prevent="$emit('addProduct', product)"
                    > -->
                        <div class="product-card bg-white rounded">
                            <div
                                class="product-img-container image-property"
                            >
                                <img
                                    :src="product.product_thumbnail"
                                    class="img-fluid"
                                />
                            </div>
                            <div
                                class="product-card-content product-content"
                            >
                                <div class="d-flex justify-content-between product-info" >
                                    <div v-if="product.has_discount">
                                        <span class="badge badge-secondary" >
                                            <del> {{ currency }}{{ product.unit_price }}</del>
                                        </span>
                                        
                                        <span class="badge badge-success ml-2">
                                            {{ currency }}{{ product.price_after_discount }}
                                        </span>
                                        <!-- <span>{{stock.product.price_after_discount}}</span> -->
                                    </div>
                                    <div v-else>
                                        <span class="badge badge-success" >
                                            {{ currency }}{{ product.unit_price }}
                                        </span>
                                    </div>
                                    
                                    <span class="badge badge-warning">
                                        {{ product.current_stock }}
                                    </span>
                                </div>
                                <div class="position-relative h-100">
                                    <div
                                        class="p-2 h-100 font-weight-bold text-center"
                                    >
                                        <h5 class="product-title">
                                            <!-- {{ product.product_languages[0].title }} -->
                                            {{ product.product_languages[0].title.length > 20 ? product.product_languages[0].title.slice(0, 20) + '...' : product.product_languages[0].title }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Infinite Scroll Trigger Element -->
                <div ref="loadMore" class="col-12 text-center m-4">
                    <div v-if="isLoading" class="loader-mask">
                        <div class="loader">
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row text-center" v-else>
                <div class="col-12">
                    <h4>No products available !</h4>
                </div>
            </div>
        </div>
    </div>


    <!-- Variant Selection Modal -->
    <div v-if="selectedProduct && showVariantModal" class="modal fade show" style="display: block;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="max-height: 85vh; overflow-y: auto;">
                <div class="modal-header">
                    <h5 class="modal-title">Select a Variant</h5>
                    <button type="button" class="close" @click="closeVariantModal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="img-fluid">
                                <img
                                    :src="selectedProduct.product_thumbnail"
                                    class="img-fluid"
                                />
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h3 class="product-title">{{ selectedProduct.product_languages[0].title }}</h3>
                            <div class="brand" v-if="selectedProduct.brand_id"> 
                                <strong class="theme-color">BRAND: </strong> 
                                <span class="brand-title">{{ selectedProduct.brand.languages[0].title }}</span> </div>
                            <hr>

                            <div v-for="(variant, idx) in selectedProduct.variants" :key="idx">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <img
                                            :src="variant.product_variant_image"
                                            class="img-fluid"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="in-stock" v-if="variant.current_stock > 0"><i class="far fa-circle-check"></i> 
                                            In Stock <span> {{ variant.current_stock }} </span>
                                        </h6>
                                        <h6 class="out-of-stock" v-else><i class="far fa-circle-xmark"></i> Out Of Stock</h6>
                                        <br>

                                        <p class="mt-2"><span class="variant">{{ variant.name }}</span></p>

                                        <div v-if="selectedProduct.has_discount">
                                            <h3 class="theme-color mt-3 mb-0">
                                                {{ currency }}{{ getDiscountedPrice(selectedProduct, variant.unit_price) }}
                                            </h3>
                                            
                                            <del class="mr-2 text-danger"><small>{{ currency }}{{ variant.unit_price }}</small></del> 
                                            <span class="theme-color">
                                                <span v-if="selectedProduct.product_details.discount_type == 'flat'">
                                                    {{ currency }}{{ selectedProduct.product_details.discount }}
                                                </span>
                                                <span v-else>
                                                    {{ selectedProduct.product_details.discount }}%
                                                </span>
                                                off
                                            </span>
                                        </div>

                                        <h3 class="theme-color mt-3 mb-0" v-else>
                                            {{ currency }}{{ variant.unit_price }}
                                        </h3>


                                        <!-- <button class="btn btn-primary mb-2" @click="selectVariant(variant)">
                                            {{ variant.name }} - {{ currency }}{{ variant.unit_price }}
                                        </button> -->
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-theme" @click="selectVariant(variant)">
                                            Add
                                        </button>
                                    </div>
                                </div> <hr>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
export default {
    name: "Stock",
    props: ['brands', 'categories', 'currency', 'baseUrl', 'clearMe', 'isAdmin'],
    data() {
        return {
            products: [],
            selectedBrands: [],
            selectedCategories: [],
            searchProduct: '',
            brandDrawer: false,
            categoryDrawer: false,
            productSearchResultClearIcon: false,
            timeout: null,
            itemsPerPage: 12,
            page: 1,
            isLoading: false,
            selectedProduct: null,
            showVariantModal: false,
            allProductsLoaded: false,
            observer: null,
        }
    },

    watch: {
        options: {
            handler() {
                this.getProducts();
            },
            deep: true,
        },

        searchProduct(value, oldVal) {
            if (value.length) {
                this.productSearchResultClearIcon = true;                
            } else {
                this.productSearchResultClearIcon = false;
            }

            if (value.length >= 2 || oldVal.length >= 2) {
                if (this.timeout) {
                    clearTimeout(this.timeout);
                }
                this.timeout = setTimeout(() => {
                    this.page = 1;  // Reset page to 1 on new search
                    this.products = []; // Clear existing products for new search
                    this.allProductsLoaded = false; // Allow loading more products
                    this.getProducts();
                }, 500);
            }
        },

        selectedBrands(value, oldVal) {
            this.page = 1;
            this.products = []; 
            this.allProductsLoaded = false; 
            this.getProducts();
        },

        selectedCategories(value, oldVal) {
            this.page = 1;
            this.products = []; 
            this.allProductsLoaded = false; 
            this.getProducts();
        },
        
        clearMe(value, oldVal) {
            this.selectedBrands = [];
            this.selectedCategories = [];
            this.searchProduct = '';
            this.allProductsLoaded = true; 
            this.getProducts();
        },
    },

    async mounted() {
        if (this.isAdmin) {
            await this.getProducts();
        } else if (!this.isAdmin) {
            await this.getProducts();
            // this.$emit('loadProducts', this.products);
        }

        this.initializeObserver();
    },

    beforeDestroy() {
        if (this.observer) this.observer.disconnect();
    },

    computed: {
        latestCheckedValue() {
            
        },
    },

    methods: {
        initializeObserver() {
            const options = {
                root: null,
                rootMargin: "0px",
                threshold: 0.1
            };
            this.observer = new IntersectionObserver(this.onIntersection, options);
            this.observer.observe(this.$refs.loadMore);
        },

        async getProducts() {
            if (this.allProductsLoaded || this.isLoading) return;
            this.isLoading = true;
            try {
                const response = await axios.get(
                    `${this.baseUrl}/pos/stocks?per_page=${this.itemsPerPage}&page=${this.page}&search=${this.searchProduct}&brands=${JSON.stringify(this.selectedBrands)}&categories=${JSON.stringify(this.selectedCategories)}`
                );
                const newProducts = response.data.data.data;
                if (newProducts.length < this.itemsPerPage) {
                    this.allProductsLoaded = true; // Stop loading if no more products
                }
                this.products = [...this.products, ...newProducts];
                this.page += 1;
                this.$emit('loadProducts', this.products);
            } catch (error) {
                console.error(error);
            } finally {
                this.isLoading = false;
            }
        },
        onIntersection(entries) {
            const entry = entries[0];
            if (entry.isIntersecting) {
                this.getProducts();
            }
        },

        toggleBrandDrawer(e) {
            this.brandDrawer = !this.brandDrawer;
        },

        toggleCategoryDrawer(e) {
            this.categoryDrawer = !this.categoryDrawer;
        },

        clearBrandDrawer(e) {
            this.brandDrawer = !this.brandDrawer;
            this.selectedBrands = []
        },

        clearCategoryDrawer(e) {
            this.categoryDrawer = !this.categoryDrawer;
            this.selectedCategories = []
        },

        handleProductClick(product) {
            if (product.has_variant) {
                this.selectedProduct = product;
                this.showVariantModal = true;
            } else {
                this.$emit('addProduct', product, null);
            }
        },
        closeVariantModal() {
            this.showVariantModal = false;
            this.selectedProduct = null;
        },
        selectVariant(variant) {
            this.showVariantModal = false;
            this.$emit('addProduct', this.selectedProduct, { ...variant });
            this.selectedProduct = null;
        },

        getDiscountedPrice(product, variant_price) {
            let price = variant_price;

            const discount = product.product_details?.discount;
            const discountType = product.product_details?.discount_type;

            if (discountType) {
                if (discountType === "flat") {
                    price = price - discount;
                } else {
                    price = price - ((price * discount) / 100);
                }
            }
            
            return price;
        },
    }
}
</script>

<style scoped>
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

.theme-color {
    color: #0e947a;
}

.brand {
    font-size: 14px;
}

.in-stock {
    font-weight: 400;
    padding: 8px;
    background-color: rgb(79 255 112 / 13%);
    border-radius: 5px;
    color: #03a016;
    display: inline-block;
}

.out-of-stock {
    font-weight: 400;
    padding: 8px;
    background-color: rgba(255, 79, 79, 0.1);
    border-radius: 5px;
    color: #ff4f4f;
    display: inline-block;
}

.variant {
    font-size: 14px;
    padding: 2px 10px;
    border-radius: 5px;
    border: 1px solid #0e947a;
}

.btn-theme {
    font-size: 16px;
    padding: 10px 20px;
    border: 1px solid #21b06880;
    background-color: rgb(79 255 112 / 13%);
}

.product-card {
    box-shadow: 2px 4px 8px #0d995321;
}

.language-drawer {
    width: 97%;
    left: 8px;
    margin: 0;
    border: 1px solid #0e94793b;
}
.language-drawer .drawer-list {
    overflow-y: auto !important;
}
.product-section {
    overflow-y: auto !important;
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

.product-img-container{
    width: 100%;
    height: 210px;
    display: flex;
    align-items: center;
    justify-content: center;

}
.product-img-container img{
    height: auto;
    max-height: 170px;
    width: auto;
    max-width: 170px;
}

@media (max-width: 1400px) {
.product-img-container{
    height: 120px;
}
.product-img-container img{
    height: auto;
    max-height: 90px;
    width: auto;
    max-width: 90px;
}
}

@media (max-width: 767px) {

}

@media only screen and (max-width: 991px) and (min-width: 768px){

}
@media (max-width: 480px) {

}
</style>