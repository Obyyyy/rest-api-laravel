<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const API_URL = "http://127.0.0.1:8000/api/buku";

    public function index(Request $request)
    {
        $url = static::API_URL;
        $current_url = url()->current();

        if($request->input('page') != '') {
            $url .= "?page=". $request->input('page');
        }

        $client = new Client();
        $response = $client->request('GET', $url);
        $contents = $response->getBody()->getContents();
        $contentsArray = json_decode($contents, true);
        $data = $contentsArray['data'];
        foreach($data['links'] as $key => $value) {
            $data['links'][$key]['url2'] = str_replace(static::API_URL, $current_url, $value['url']);
        }
        return view('buku.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataInput = [
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'tanggal_publikasi' => $request->tanggal_publikasi,
        ];

        $client = new Client();
        $url = "http://127.0.0.1:8000/api/buku";
        $response = $client->request('POST', $url, [
            'headers' => ['Content-type' => 'application/json'],
            'body' => json_encode($dataInput),
        ]);

        $contents = $response->getBody()->getContents();
        $contentsArray = json_decode($contents, true);
        if($contentsArray['status'] != true) {
            $error = $contentsArray['data'];
            return redirect()->to('buku')->withErrors($error)->withInput();
        } else {
            return redirect()->to('buku')->with('success', 'Berhasil menambahkan data');
        }

        // return redirect()->route('buku');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = new Client();
        $url = "http://127.0.0.1:8000/api/buku/$id";
        $response = $client->request('GET', $url);
        $contents = $response->getBody()->getContents();
        $contentsArray = json_decode($contents, true);
        if ($contentsArray['status'] != true) {
            $error = $contentsArray['message'];
            return redirect()->to('buku')->withErrors($error);
        } else {
            $data = $contentsArray['data'];
            return view('buku.index', compact('data'));
        }

        return view('buku.index', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataInput = [
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'tanggal_publikasi' => $request->tanggal_publikasi,
        ];

        $client = new Client();
        $url = "http://127.0.0.1:8000/api/buku/$id";
        $response = $client->request('PUT', $url, [
            'headers' => ['Content-type' => 'application/json'],
            'body' => json_encode($dataInput),
        ]);

        $contents = $response->getBody()->getContents();
        $contentsArray = json_decode($contents, true);
        if($contentsArray['status'] != true) {
            $error = $contentsArray['data'];
            return redirect()->to('buku')->withErrors($error)->withInput();
        } else {
            return redirect()->to('buku')->with('success', 'Berhasil mengedit data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = new Client();
        $url = "http://127.0.0.1:8000/api/buku/$id";
        $response = $client->request('DELETE', $url);

        $contents = $response->getBody()->getContents();
        $contentsArray = json_decode($contents, true);
        if($contentsArray['status'] != true) {
            $error = $contentsArray['data'];
            return redirect()->to('buku')->withErrors($error)->withInput();
        } else {
            return redirect()->to('buku')->with('success', 'Berhasil menghapus data');
        }
    }
}