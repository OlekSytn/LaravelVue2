<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="loading" v-if="loading">Loading...</div>
        <div v-if="error" class="error">
          {{ error }}
        </div>
        <table v-if="produtos" class="table">
          <thead>
            <tr>
              <td>id</td>
              <td>Nome Produto</td>
              <td>Valor</td>
              <td>Actions</td>
            </tr>
          </thead>
          <tbody v-if="produtos">
            <tr
              v-for="(
                {
                  CD_PRODUTO,
                  NM_PRODUTO,
                  VL_PRODUTO,
                  statusButton = 'Editar',
                  loading,
                },
                index
              ) in produtos"
              v-bind:key="index"
            >
              <template v-if="loading == false">
                <td>
                  <form
                    v-on:submit.prevent.self
                    @submit="handleButtonEdit(index)"
                    :id="'form' + index"
                    :action="url + '/' + (CD_PRODUTO || id)"
                  >
                    <input
                      v-if="statusButton == 'Atualizar'"
                      v-model="produtos[index].CD_PRODUTO || produtos[index].id"
                      type="text"
                      hidden
                    />
                  </form>
                  <span>{{ CD_PRODUTO || id }}</span>
                </td>
                <td>
                  <input
                    :form="'form' + index"
                    v-if="statusButton == 'Cancelar'"
                    v-model="produtos[index].NM_PRODUTO"
                    type="text"
                  />
                  <span v-if="statusButton == 'Editar'">{{ NM_PRODUTO }}</span>
                </td>
                <td>
                  <input
                    :form="'form' + index"
                    v-if="statusButton == 'Cancelar'"
                    v-model="produtos[index].VL_PRODUTO"
                    type="text"
                  />
                  <span v-if="statusButton == 'Editar'">{{ VL_PRODUTO }}</span>
                </td>
                <td>
                  <button
                    v-if="statusButton == 'Cancelar'"
                    :form="'form' + index"
                    type="submit"
                    @click="enviarForm(index)"
                    class="btn btn-primary"
                  >
                    Atualizar
                  </button>
                  <button
                    :form="'form' + index"
                    type="button"
                    @click="handleButtonEdit(index)"
                    class="btn btn-primary"
                  >
                    {{ statusButton }}
                  </button>
                  <button
                    type="button"
                    @click="removeProduct(index, 1)"
                    class="btn btn-primary"
                  >
                    Remover
                  </button>
                </td>
              </template>
              <template v-else>
                <td colspan="4" class="text-center">...loading</td>
              </template>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  props: ["url"],
  data() {
    return {
      loading: false,
      produtos: null,
      error: null,
      produtosEdit: [],
      idProduto: null,
      nomeProduto: null,
      valorProduto: null,
      // statusButton: "Editar"
    };
  },
  // created () {

  // },
  mounted() {
    this.getProdutos();
    window.Echo.channel("novoProduto").listen("NewProduct", (e) => {
      e.data.produto.statusButton = "Editar";
      e.data.produto.loading = false;
      this.produtos.push(e.data.produto);
    });
    window.Echo.channel("novoProduto").listen("UpdateProduct", (e) => {
      e.data.produto.statusButton = "Editar";
      e.data.produto.loading = false;
      const index = this.produtos.findIndex(
        (produto) =>
          (produto.CD_PRODUTO || produto.id) === e.data.produto.CD_PRODUTO
      );
      this.produtos.splice(index, 1, e.data.produto);
      //   this.produtos.push(e.data.produto);
    });
  },
  methods: {
    getProdutos() {
      this.error = this.produtos = null;
      axios
        .get(this.url)
        .then((response) => {
          if (this.produtos != response.data) {
            this.loading = false;
            response.data.forEach(async (e) => {
              e.statusButton = "Editar";
              e.loading = false;
            });

            this.produtos = response.data;
          }
        })
        .catch((error) => {
          this.loading = false;
          this.error = error.response.data.message || error.message;
        });
    },
    handleButtonEdit(index) {
      if (this.produtos[index].statusButton == "Cancelar") {
        this.produtos[index].CD_PRODUTO =
          this.produtosEdit[index].CD_PRODUTO || this.produtosEdit[index].id;
        this.produtos[index].NM_PRODUTO = this.produtosEdit[index].NM_PRODUTO;
        this.produtos[index].VL_PRODUTO = this.produtosEdit[index].VL_PRODUTO;
        this.produtos[index].statusButton = "Cancelar";
      } else {
        this.produtosEdit[index] = { ...this.produtos[index] };
      }
      return this.produtos[index].statusButton == "Editar"
        ? (this.produtos[index].statusButton = "Cancelar")
        : (this.produtos[index].statusButton = "Editar");
    },
    removeProduct(index, quantity) {
      this.produtos.splice(index, quantity);
    },
    enviarForm(index) {
      this.produtos[index].loading = true;
      const produtoEdit = {
        idProduto: this.produtos[index].CD_PRODUTO || this.produtos[index].id,
        nomeProduto: this.produtos[index].NM_PRODUTO,
        valorProduto: this.produtos[index].VL_PRODUTO,
      };

      axios
        .post(this.url + "/" + produtoEdit.idProduto, {
          ...produtoEdit,
        })
        .then((response) => {})
        .catch((error) => {
          this.loading = false;
          this.error = error.response.data.message || error.message;
        });
    },
  },
};
</script>

