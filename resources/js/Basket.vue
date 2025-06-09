<template>
<div style="margin-top: 20px; display: flex; align-items: flex-start;">
    <div>
	<table>
	    <tr>
            <th>Название</th>
            <th>Категория</th>
            <th>Цена</th>
			<th>Количество</th>
			<th>Стоимость</th>
			<th></th>
        </tr>
        <tr v-for="item in order.basket">
	            <td><a :href="'/product/'+item.product_id">{{item.product.name}}</a></td>
		        <td>{{item.product.categoryDisplay}}</td>
				<td>{{item.itemPriceDisplay}}</td>
				<td>
				    <div style="display: flex;">
					    <a href="javascript:void(0)" @click="updateItem(item, '+')">+</a>
						{{item.count}}
						<a href="javascript:void(0)" @click="updateItem(item, '-')">-</a>
					</div>
				</td>
				<td>{{item.sumDisplay}}</td>
				<td><a href="javascript:void(0)" @click="deleteItem(item)">Удалить</a></td>
	    </tr>
	</table>
	</div>
	<div style="margin-left: 40px; display: flex; flex-direction: column; align-items: center;">
	    <h2>Оформление заказа</h2>
        <div class="mb-3 row">
            <label for="fio" class="col-md-4 col-form-label text-md-end text-start">Фио</label>
            <div class="col-md-6">
                <input type="text" class="form-control" :class="order.errors.fio.length ? 'is-invalid' : ''" id="fio" v-model="order.fields.fio">
                <span v-if="order.errors.fio.length" class="text-danger">{{order.errors.fio[0]}}</span>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="comment" class="col-md-4 col-form-label text-md-end text-start">Коментарий</label>
            <div class="col-md-6">
                <textarea class="form-control" :class="order.errors.comment.length ? 'is-invalid' : ''" id="comment" v-model="order.fields.comment"></textarea>
                <span v-if="order.errors.comment.length" class="text-danger">{{order.errors.comment[0]}}</span>
            </div>
        </div>
		<div class="mb-3 row">
		    <span v-if="order.errors.errorMessage.length" class="text-danger">{{order.errors.errorMessage[0]}}</span>
		</div>
		<button class="btn btn-primary" @click="orderCreate">Оформить закзаз</button>
	</div>
</div>
</template>
<script>
import $ from 'jquery'

export default {
    components: {
    },
    data() {
        return {
			order: {
			    basket: [],
			    fields: {
				    fio: '',
					comment: '',
				},
			    errors: {
				    fio: [],
					comment: [],
					errorMessage: [],
				},
			}
        };
    },
	provide() {
        return {
            appData: this,
        }
    },
    async mounted() {
        this.getList();
    },
    methods: {
	
		async getList() {
			let rs = await this.request('/basket/getList', 'get');
			this.order.basket = Object.assign([], rs.list);
			if (!this.order.basket.length) location.href=location.href;
		},
		async updateItem(item, operation) {
			await this.request('/basket/updateItem', 'post', {product_id: item.product_id, operation: operation});
			this.getList();
		},
		async deleteItem(item) {
			await this.request('/basket/deleteItem', 'post', {product_id: item.product_id});
			this.getList();
		},
		async orderCreate() {
			let rs = await this.request('/order', 'post', this.order);
			console.log(rs);
			
			if (rs.status != 'success') {
			    this.order.errors = Object.assign({
				    fio: [],
				    comment: [],
				errorMessage: [],
			    }, rs.errors);
				return;
			}
			location.href = '/order/'+rs.id;
		},
		request(action, method, data={}) {
		    return new Promise((resolve, reject)=> {
                $.ajax({
	                url: action,
	                method: method,
	                headers: {'X-CSRF-TOKEN': $('meta[name="csrf"]').attr('content')},
	                dataType: 'json',
					data: data,
	                success: function(rs){
					    resolve(rs.data);
	                },
					error: function (jqXHR, exception) {
					    resolve({errors: jqXHR.responseJSON?.errors});
					},
                });
			});
		},

		

    },
	
	
};
</script>