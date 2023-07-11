<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";

const bouquets = ref([]);

onMounted(async () => {
    const response = await axios.get(
        "https://d2lj6flnyarw45.cloudfront.net/bouquets/index.json"
    );
    bouquets.value = response.data.collection;
});
</script>

<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addProduct"
                >
                    Add Prouduct
                </button>
            </div>
        </div>
        <div class="row">
            <div
                v-for="bouquet in bouquets"
                :key="bouquet.index"
                class="col-md-5 m-5"
            >
                <div class="card">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                name: {{ bouquet.name }}
                            </li>
                            <li class="list-group-item">
                                sku: {{ bouquet.sku }}
                            </li>
                            <li class="list-group-item">
                                price:
                                {{ bouquet.price_currency_formatted }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="modal fade"
            id="addProduct"
            tabindex="-1"
            aria-labelledby="addProductLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Add Product
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3 row">
                                <div class="col-6">
                                    <label for="namePrefix" class="form-label"
                                        >Name Prefix</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="namePrefix"
                                        id="namePrefix"
                                    />
                                </div>
                                <div class="col-6">
                                    <label for="nameSuffix" class="form-label"
                                        >Name Suffix</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="nameSuffix"
                                        id="nameSuffix"
                                    />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-6">
                                    <label for="sku" class="form-label"
                                        >SKU</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="sku"
                                        id="sku"
                                    />
                                </div>
                                <div class="col-6">
                                    <label for="sku" class="form-label"
                                        >Price(Euro)</label
                                    >
                                    <input
                                        type="number"
                                        class="form-control"
                                        name="price"
                                        id="price"
                                    />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="permalink" class="form-label"
                                    >Permalink</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="permalink"
                                    name="permalink"
                                />
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
