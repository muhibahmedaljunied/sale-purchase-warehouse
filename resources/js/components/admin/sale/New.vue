<template>
  <div class="wrapper">
    <div class="container-fluid">
      <div class="card text-right">
        <div class="card-header">
          <h1>فاتوره المبيعات <span id="codigo"></span></h1>
        </div>
        <div class="card-body">
          <div class="row">

            <div class="col-md-4">
              <h5 class="card-title">اختر المنتج</h5>
              <div class="custom-search">

                <input :id="'Sale_product_tree'" type="text" readonly class="custom-search-input">
                <input :id="'Sale_product_tree_id'" type="hidden" readonly class="custom-search-input">

                <button class="custom-search-botton" type="button" data-toggle="modal" data-target="#exampleModalProduct">
                  <i class="fa fa-plus-circle"></i></button>
              </div>
            </div>
            <div class="col-md-4">
              <h5 class="card-title">اختر المخزن</h5>
              <div class="custom-search">

                <input :id="'Sale_store_tree'" type="text" readonly class="custom-search-input">
                <input :id="'Sale_store_tree_id'" type="hidden" readonly class="custom-search-input">

                <button class="custom-search-botton" type="button" data-toggle="modal" data-target="#exampleModalStore">
                  <i class="fa fa-plus-circle"></i></button>
              </div>
            </div>
            <div class="col-md-2">
              <h5 class="card-title">اسم الحساب</h5>
              <div class="custom-search">

                <select class="form-control" style="background-color: beige;" name="forma_pago" id="select_account_Sale">

                </select>
                <!-- <input :id="'Sale_account_id'" type="hidden" readonly class="custom-search-input"> -->

              </div>
            </div>


          </div>
          <br>
          <hr>

          <div class="row">
            <div class="col-md-12">
              <table class="table table-bordered text-right" style="width: 100%; font-size: x-large">
                <thead>
                  <tr>
                    <!-- <th>Code</th> -->
                    <th>المنتج</th>

                    <th>المخزن</th>
                    <th>الحاله</th>
                    <th> المواصفات والطراز</th>
                    <th>الكميه المنوفره</th>
                    <th>الوحده</th>
                    <th>السعر</th>
                    <th>الكميه</th>
                    <th>الضريبه</th>
                    <th>الاجمالي</th>
                    <th>اضافه</th>
                  </tr>
                </thead>
                <tbody v-if="all_products && all_products.length > 0">
                  <!-- <tr v-for="(products, index) in product"> -->
                  <tr v-for="(product, index) in all_products" :key="index">
                    <!-- <td><input type="text" value="123" id="codigo0" class="form-control input_codigo" readonly=""></td> -->
                    <td>
                      <div id="factura_producto" class="input_nombre">
                        {{
                          product.product
                        }}<input type="hidden" v-model="product.id" id="id" />
                      </div>
                    </td>



                    <td>
                      <div id="factura_producto" class="input_nombre">
                        {{
                          product.store
                        }}<input type="hidden" v-model="product.store_id" id="store_temporale" />
                      </div>
                    </td>

                    <td>
                      <div id="factura_producto" class="input_nombre">
                        {{ product.status }}
                      </div>
                    </td>
                    <td>
                      <div id="factura_producto" class="input_nombre">
                        {{ product.desc }}
                      </div>
                    </td>
                    <td>
                      <div id="factura_producto" class="input_nombre" v-if="product.availabe_qty">


                        <div v-for="temx in product.units">



                         


                            <span v-if="temx.unit_type == 0">

                              <span v-if="product.quantity / product.rate >= 1">
                                {{ Math.floor((product.quantity / product.rate)) }}{{
                                  product.units[0].name
                                }}
                              </span>

                              <span v-if="product.quantity % product.rate >= 1">
                                {{ Math.floor((product.quantity % product.rate)) }}{{
                                  product.units[1].name
                                }}
                              </span>
                            </span>

                        
                      
                        </div>



                      </div>

                    </td>


                    <td>
                      <div id="factura_producto" class="input_nombre">





                        <select v-if="check_state[index] == true" style="background-color: beige;"
                          :id="'select_unit' + index" v-model="unit[index]" name="type" class="form-control" required>

                          <option disabled v-for="unit in product.units"
                            v-bind:value="[unit.id, unit.rate, unit.unit_type]">
                            {{ unit.name }}
                          </option>


                        </select>


                        <select v-else style="background-color: beige;" :id="'select_unit' + index" v-model="unit[index]"
                          name="type" class="form-control" required>

                          <option v-for="unit in product.units" v-bind:value="[unit.id, unit.rate, unit.unit_type]">
                            {{ unit.name }}
                          </option>


                        </select>





                      </div>
                    </td>
                    <td>
                      <input v-if="check_state[index] == true" readonly type="number" v-model="product.cost" id="price"
                        class="form-control input_cantidad" onkeypress="return " />

                      <input v-else type="number" v-model="product.cost" id="price" class="form-control input_cantidad"
                        onkeypress="return " />
                    </td>
                    <td>
                      <!-- <input style="background-color: beige;" type="number" @input="on_input(qty[index], product.availabe_qty), calculate_price(product.cost, qty[index],
                    index)" v-model="qty[index]" id="qty" class="form-control input_cantidad" onkeypress="return " /> -->
                      <input v-if="check_state[index] == true" readonly style="background-color: beige;" type="number"
                        @input="calculate_price(index)" v-model="qty[index]" id="qty" class="form-control input_cantidad"
                        onkeypress="return " />

                      <input v-else style="background-color: beige;" type="number" @input="calculate_price(index)"
                        v-model="qty[index]" id="qty" class="form-control input_cantidad" onkeypress="return " />
                    </td>
                    <td>
                      <input v-if="check_state[index] == true" readonly type="number" v-model="tax[index]" id="qty"
                        class="form-control input_cantidad" onkeypress="return " @input="calculate_price(index)" />

                      <input v-else type="number" v-model="tax[index]" id="qty" class="form-control input_cantidad"
                        onkeypress="return " @input="calculate_price(index)" />
                    </td>

                    <td>


                      <input type="number" v-model="total[index]" :id="'total_row' + index" class="form-control"
                        readonly />
                    </td>

                    <td>
                      <input v-model="check_state[index]" @change="add_one_sale(

product.id,
                        product.product_id,
                        qty[index],
                        product.desc,
                        product.availabe_qty,
                        unit[index],
                        product.store_id,
                        product.status_id,
                        product.cost,
                        tax[index],
                        index,
                        total



                      )" type="checkbox" class="btn btn-info waves-effect">
                    </td>

                  </tr>



                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="10">
                      <h3> لايوجد بيانات </h3>
                    </td>
                  </tr>
                </tbody>

                <tfoot>



                  <tr>
                    <td colspan="11">
                      <label for="pagoPrevio">اجمالي الكميه</label>
                      <input type="text" readonly="readonly" id="cantidad_total" class="form-control"
                        v-model="total_quantity" />
                    </td>
                  </tr>
                  <tr>
                    <td colspan="11">
                      <label for="impuestosTotales">اجمالي الضريبه</label>
                      <input type="text" readonly="readonly" id="impuestos_totales" class="form-control"
                        v-model="total_tax" />
                    </td>

                  </tr>
                  <tr>
                    <td colspan="11">
                      <label for="subTotal">الاجمالي (مع الضريبه) <small></small></label>

                      <input type="text" readonly id="subtotal_general" name="subtotal_general" class="form-control"
                        v-model="grand_total" />
                      <input type="hidden" id="subtotal_general_sf" name="subtotal_general_sf" class="form-control"
                        value="0.00" />
                    </td>
                  </tr>
                  <tr>
                    <td colspan="11">
                      <label for="subTotal">الاجمالي (بدون ضريبه) <small></small></label>
                      <input type="text" readonly id="subtotal_general_si" name="subtotal_general_si" class="form-control"
                        value="0.00" v-model="sub_total" />

                    </td>
                  </tr>
                </tfoot>

              </table>
            </div>
          </div>


          <div class="row">
            <div class="col-md-12">


              <div class="row">

                <div class="col-md-12"> <label for="pagoPrevio">نوع العمله</label>
                  <select name="forma_pago" class="form-control" id="forma_pago">
                    <option v-bind:value="2">ريال يمني </option>
                    <option v-bind:value="1">دولار امريكي</option>
                    <option v-bind:value="2">ريال سعودي </option>
                  </select>
                </div>

                <div class="col-md-12">
                  <label for="pagoPrevio">البيان</label>


                  <input class="form-control" style="background-color: beige;" type="text" v-model="description">


                </div>





                <div class="col-md-12">
                  <label for="FormaPago">طريقه الدفع</label>
                  <select style="background-color: beige;" name="forma_pago" class="form-control" id="forma_pago"
                    v-model="Way_to_pay_selected" v-on:change="onwaychange">
                    text
                    <!-- <option v-bind:value="1">cash Money</option>
<option v-bind:value="2">Credit</option> -->
                    <option v-bind:value="1">نقد</option>
                    <option v-bind:value="2">أجل</option>
                    <option v-bind:value="3">بنك</option>
                  </select>
                </div>



                <div class="col-md-12">
                  <label for="cliente"> العميل</label>

                  <select style="background-color: beige;" v-model="customer" id="customer" class="form-control">
                    <option v-for="cust in customers" v-bind:value="[cust.id, cust.name, cust.account_id]">
                      {{ cust.name }}
                    </option>
                  </select>
                </div>
                <div class="col-md-12" >
                  <label for="pagoPrevio">الصندوق</label>
                  <select style="background-color: beige;" v-model="treasury" id="supplier" class="form-control">
                    <option v-for="tre in treasuries" v-bind:value="[tre.id, tre.name, tre.account_id]">
                      {{ tre.name }}
                    </option>
                  </select>

                </div>


                <div class="col-md-12">
                  <label for="date">التاريخ</label><br />

                  <input style="background-color: beige;" name="date" type="date" v-model="date" class="form-control" />
                </div>


                <div class="col-md-12">
                  <label for="pagoPrevio">الخصم (%)</label>
                  <input type="number" @input="take_discount" v-model="discount" :min="0" :max="99" :step="1"
                    oninput="validity.valid||(value='');" class="form-control input_cantidad" onkeypress="return " />

                </div>

                <div class="col-md-12" v-show="show">
                  <label for="pagoPrevio">المدفوع</label>
                  <input type="text" id="paid" v-on:input="credit" class="form-control" v-model="(paid = To_pay)"
                    style="color: red" />
                  <input type="hidden" id="items_totales" />
                  <input type="hidden" id="registros_totales" />
                </div>
                <div class="col-md-12" v-show="show">
                  <label for="pagoPrevio">المتبقي</label>
                  <input type="text" readonly="readonly" id="remaining" class="form-control" v-model="remaining" />
                  <input type="hidden" id="items_totales" />
                  <input type="hidden" id="registros_totales" />
                </div>

                <div class="col-md-12">
                  <label for="pagoPrevio">تاريخ الاستحقاق</label>
                  <input type="date" id="remaining" class="form-control" v-model="remaining" />

                </div>

                <div class="col-md-12">
                  <label for="total" class="text-left">TO PAY (USD):</label>
                  <div class="col-md-12 letra_calculator_total text-center" id="div_total">
                    {{ To_pay }}
                  </div>
                  <input type="hidden" name="total" id="total" v-model="To_pay" />
                </div>
                <div class="col-md-12">
                  <div class="text-center">
                    <a style="
              width: 100%;
              padding-top: 0.5em;
              padding-bottom: 0.5em;
              font-size: 18pt;
            " href="javascript:void" @click="payment()" class="btn btn-info waves-effect waves-light" id="pagar">
                      <i class="fa fa-credit-card"></i></a>
                  </div>
                </div>
              </div>


            </div>



          </div>
        </div>

      </div>










    </div>




    <div class="modal fade" id="exampleModalProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="well" id="treeview_json_product"></div>

          </div>

        </div>
      </div>
    </div>

    <div class="modal fade" id="exampleModalStore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="well" id="treeview_json_store"></div>

          </div>

        </div>
      </div>
    </div>
    <div class="modal fade" id="exampleModalAcoount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="well" id="treeview_json_account"></div>

          </div>

        </div>
      </div>
    </div>




  </div>
</template>



<script>
import operation from '../../../../js/operation.js';
import tree from '../../../../js/tree/tree.js';
export default {
  mixins: [operation, tree],
  data() {
    // return data;
    return {
      cost: [],
      account: '',
      // product: [],
      qty: [],
      unit: [],
      // desc: [],
      // store: [],
      // status: [],
      store_product_id:[],
      counts: {},
      count: 1,
      date: new Date().toISOString().substr(0, 10),
      dateselected: new Date().toISOString().substr(0, 10),
      expiry_date: new Date().toISOString().substr(0, 10),
      table: '',
      type: '',
      type_refresh: '',
      note: "",
      detail: '',
      Total_quantity: 0,
      total_quantity: 0,
      check_state: [],
      return_qty: [],
      price: [],
      tax: [],
      products: '',
      stores: '',
      statuses: '',
      stores: '',
      statuses: '',
      units: '',
      opening: '',
      availabe_qty: [],
      word_search: '',
      total: [],
      customer: [],
      supplier: [],
      suppliers: '',
      customers: '',
      seen: false,
      id: '',

      index: 0,
      all_products: '',
      jsonTreeData: '',
      type_of_tree: 1,
      indexselected: '',

      last_nodes: '',


      statusselected: 0,
      unitselected: 0,
      unitselectedname: '',
      productselected: 0,
      productselectedname: "",
      storeselectedname: "",
      storeselected: 0,
      descselected: "",
      operationselected: 0,
      dateselected: 0,
      typeselected: [],
      checkselected: '',
      // ------------------------------------------------------------

      description: '',
      treasury: '',
      all_products: '',
      temporale: 1,
      supplier: [],
      suppliers: '',
      total_quantity: 0,
      grand_total: 0,
      sub_total: 0,
      To_pay: 0,
      discount: 0,
      total_tax: 0,
      type_payment: 0,
      Way_to_pay_selected: 1,
      show: false,
      paid: 0,
      remaining: 0,
      return_qty: [],

    }
  },
  created() {

  },
  mounted() {
    this.list();

    this.type = 'Sale';
    this.type_refresh = 'decrement';

    this.type_of_tree = 1;

    this.showtree('store');
    this.showtree('product');
    this.showtree('account');


  },

  methods: {
    show_modal(id) {
      $("#vaciar1").val(id);
    },

    list(page = 1) {
      this.axios
        .post(`/sale/newsale?page=${page}`)
        .then(({ data }) => {

          this.products = data.products;
          this.customers = data.customers;
          this.treasuries = data.treasuries;



        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

    take_discount() {

      this.sub_total *= parseInt(this.discount) / 100;
      // this.sub_total = this.sub_total/100;
    },
    calculate_price(index) {

      var unit = $(`#select_unit${index}`).val();
      unit = unit.split(",");



      if (unit[2] == 0) {

        this.total[index] = this.all_products[index].cost * this.qty[index];

      }

      if (unit[2] == 1) {

        this.total[index] = this.all_products[index].cost * unit[1] * this.qty[index];

      }
      if (this.tax[index]) {

        this.total[index] = parseInt(this.total[index]) + parseInt(this.tax[index]);

      }

      // console.log(this.total);

      if (this.qty[index] == 0) {
        this.total[index] = 0;
        this.tax[index] = 0
      }




    },

    calc_grand_total(index) {


      this.grand_total = 0;

      for (let i = 0; i <= index; i++) {


        if (this.total[i]) {

          this.grand_total = parseInt(this.total[i]) + parseInt(this.grand_total);

        } else {

          this.grand_total = parseInt(0) + parseInt(this.grand_total);
        }



      }

    },

    calc_tax(index) {

      this.total_tax = 0;

      for (let i = 0; i <= index; i++) {



        if (this.tax[i]) {

          this.total_tax = parseInt(this.tax[i]) + parseInt(this.total_tax);

        } else {

          this.total_tax = parseInt(0) + parseInt(this.total_tax);
        }

        // console.log(total_quantity);

      }
    },
    calc_qty(index) {

      this.total_quantity = 0;
      for (let i = 0; i <= index; i++) {



        if (this.qty[i]) {

          this.total_quantity = parseInt(this.qty[i]) + parseInt(this.total_quantity);

        } else {

          this.total_quantity = parseInt(0) + parseInt(this.total_quantity);
        }



      }
    },
    onwaychange(e) {
      let input = e.target;
      this.type_payment = input.value;
      if (input.value == 2) {
        this.show = true;
      } else {
        this.show = false;
      }
    },
    add_one_sale(
      store_product_id,
      product,
      qty,
      desc,
      availabe_qty,
      unit,
      store,
      status,
      price,
      tax,
      index,
      total
    ) {

      var result;

      if (this.check_state[index] == true) {

        result = this.check_qty(qty, unit, availabe_qty);

        if (result == 0) { return 0; }

        this.calc_grand_total(index);
        this.calc_tax(index);
        this.calc_qty(index);

        this.To_pay = this.grand_total;
        this.sub_total = parseInt(this.grand_total) - parseInt(this.total_tax)

        this.counts[index] = index;

        this.store_product_id[index]=store_product_id,
        this.qty[index] = qty;

        this.unit[index] = unit;
        this.tax[index] = tax;
       


      }
      else if (this.check_state[index] == false) {


        if (!this.total[index]) { this.total[index] = 0; }
        if (!this.tax[index]) { this.tax[index] = 0; }
        if (!this.qty[index]) { this.qty[index] = 0; }

        this.$delete(this.counts, index);
        this.grand_total = parseInt(this.grand_total) - parseInt(this.total[index]);
        this.sub_total = parseInt(this.grand_total) - parseInt(this.tax[index]);
        this.total_tax = parseInt(this.total_tax) - parseInt(this.tax[index]);
        this.total_quantity = parseInt(this.total_quantity) - parseInt(this.tax[index]);

        this.total[index] = 0;
        this.qty[index] = 0;
        this.tax[index] = 0;




      }
      console.log(this.counts, index);
      console.log(this.store_product_id, index);
      console.log(this.qty, index);
      console.log(this.unit, index);
      console.log(this.tax, index);
      console.log(this.total, index);
    },
    on_input(qty, availabe_qty) {
      if (qty <= availabe_qty) {

        this.text_message = 'هذه الكميه غير متوفره ';
      }

    },
    credit(e) {
      this.remaining = this.grand_total - this.paid;
      this.To_pay = this.paid;
    },

    check_qty(qty, unit, availabe_qty) {

      var producter_qty = 0;

      if (unit[2] == 1) {

        producter_qty = qty * unit[1];
      } else {

        producter_qty = qty;
      }

      if (producter_qty > availabe_qty || qty == 0) {

        toastMessage('فشل', "تأكد من الكميه المدخله", 'error');
        return 0;

      }

      return 1;
    },
    payment() {

      this.axios
        .post(`/paySale`, {
          type: 'Sale',
          count: this.counts,
          unit: this.unit,
          qty: this.qty,
          price: this.cost,
          total: this.total,
          tax: this.tax,
          old:this.all_products,


          store_account: $(`#select_account_${this.type}`).val(),
          description: this.description,
          type_refresh: this.type_refresh,
          customer_account: this.customer[2],
          customer_id: this.customer[0],
          customer_name: this.customer[1],
          date: this.date,
          treasury_account: this.treasury[2],
          treasury: this.treasury[0],
          // -------------------
          grand_total: this.grand_total,
          sub_total: this.sub_total,
          discount: this.discount,
          total_tax: this.total_tax,
          type_payment: this.type_payment,
          remaining: this.remaining,
          paid: this.paid,
          // -------------------

          total_quantity: this.total_quantity,
        })
        .then((response) => {

          console.log(response);

          if (response.data.message == "success") {
            toast.fire({
              title: "تم البيع!",
              text: "Your product has been deleted.",
              button: "Close", // Text on button
              icon: "success", //built in icons: success, warning, error, info
              timer: 3000, //timeOut for auto-close
              buttons: {
                confirm: {
                  text: "OK",
                  value: true,
                  visible: true,
                  className: "",
                  closeModal: true,
                },
                cancel: {
                  text: "Cancel",
                  value: false,
                  visible: true,
                  className: "",
                  closeModal: true,
                },
              },
            });
          }
          // this.$router.go(0);
        });
    },

  },
};
</script>


