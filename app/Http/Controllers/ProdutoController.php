<?php

namespace App\Http\Controllers;

use App\Events\NewProduct;
use App\Events\UpdateProduct;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lista = Produto::all();

        return $lista;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produto = new Produto();
        $produto->NM_PRODUTO = $request->nomeProduto;
        $produto->VL_PRODUTO = $request->valorProduto;
        $produto->save();
        event(new NewProduct($produto));
        return  $produto;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function show(Produto $produto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function edit(Produto $produto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $produtoEdit = Produto::where('CD_PRODUTO','=',$id)->firstOrFail();        
        $produtoEdit->NM_PRODUTO = $request->nomeProduto;
        $produtoEdit->VL_PRODUTO = $request->valorProduto;
        $produtoEdit->save();

        event(new UpdateProduct($produtoEdit));
        return $id;
        // $produto->NM_PRODUTO = $request->nomeProduto;
        // $produto->VL_PRODUTO = $request->valorProduto;
        // return $produto;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produto $produto)
    {
        //
    }
}
