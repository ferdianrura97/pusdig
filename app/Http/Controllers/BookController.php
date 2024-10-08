<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Category;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Http\Controllers\Storage;

class BookController extends Controller
{
    public function index()
    {
        $title = 'Data Buku';
        $data = Book::orderBy('is_verify','asc')->get();
        return view('book.index', compact('title','data'));
    }

    public function add()
    {
        $title = 'Tambah data buku';
        $category = Category::all();
        return view('book.add', compact('title','category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            // 'simaksi_code' => 'required',
            'ringkasan' => 'required',
            // 'embed' => 'required',
            'cover' => 'required|max:10024',
            'file' => 'required|max:10024',
        ]);

        // dd($request->simaksi_code);
        
        if ($request->simaksi_code) {
            $buku = Book::where('simaksi_code', $request->simaksi_code)->first();
            $buku->judul = $request->judul;
            $buku->slug = Str::slug($request->judul);
            $buku->user_id = Auth::id();
            $buku->ringkasan = $request->ringkasan;
            // $buku->embed = $request->embed;
            $buku->file = $request->file;
            $buku->simaksi_code = $request->simaksi_code;
            $buku->penulis = $request->penulis;
            $buku->penerbit = $request->penerbit;
            $buku->jml_halaman = $request->jml_halaman;
            $buku->category_id = $request->category_id;
            $buku->is_verify = 1;
    
            $cover = $request->file('cover');
            $file = $request->file('file');
    
            if($cover)
            {
                $namacover = $cover->getClientOriginalName();
                $cover->move('cover', $namacover);
                $buku->cover = $namacover;
            }
    
            if($file)
            {
               $namafile = rand(999,9999) . $file->getClientOriginalName();
                $file->move('filebook', $namafile);
                $buku->file = $namafile;
            }
    
            $buku->save();
        }else{
            $data = new Book();
            $data->judul = $request->judul;
            $data->slug = Str::slug($request->judul);
            $data->user_id = Auth::id();
            $data->ringkasan = $request->ringkasan;
            // $data->embed = $request->embed;
            $data->file = $request->file;
            $data->simaksi_code = $request->simaksi_code;
            $data->penulis = $request->penulis;
            $data->penerbit = $request->penerbit;
            $data->jml_halaman = $request->jml_halaman;
            $data->category_id = $request->category_id;
            $data->is_verify = 1;
    
            $cover = $request->file('cover');
            $file = $request->file('file');
    
            if($cover)
            {
                $namacover = $cover->getClientOriginalName();
                $cover->move('cover', $namacover);
                $data->cover = $namacover;
            }
    
            if($file)
            {
               $namafile = rand(999,9999) . $file->getClientOriginalName();
                $file->move('filebook', $namafile);
                $data->file = $namafile;
            }
    
            $data->save();
    
            \Session::flash('sukses','Data berhasil dibuat');
        }


        return redirect('book');
    }

    public function detail($id)
    {
        $dt = Book::find($id);
        $title = 'Detail Buku';
        return view('book.detail', compact('dt','title'));
    }

    public function details($slug)
    {
        $book = Book::where('slug', $slug)->first();

        $title = 'Detail Buku';

        $postkey = 'post_' . $book->id;
        if (!Session::has($postkey)) {
            $book->increment('view_count');
            Session::put($postkey, 1);
        }

        $comment = Comment::all();
        return view('book.details', compact('book', 'title','comment'));
    }

    public function read($slug)
    {
        $book = Book::where('slug', $slug)->first();

        return view('book.read', compact('book'));
    }

    public function edit($id)
    {
        $title = 'Edit Buku';
        $dt = Book::find($id);
        $category = Category::all();
        return view('book.edit', compact('title', 'dt','category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            // 'simaksi_code' => 'required',
            'ringkasan' => 'required',
            // 'embed' => 'required',
            'cover' => 'required|max:10024',
            'file' => 'required|max:10024',
        ]);

        $data = Book::findOrFail($id);
        $data->judul = $request->judul;
        $data->slug = Str::slug($request->judul);
        $data->user_id = Auth::id();
        $data->ringkasan = $request->ringkasan;
        $data->penulis = $request->penulis;
        $data->penerbit = $request->penerbit;
        $data->jml_halaman = $request->jml_halaman;
        $data->category_id = $request->category_id;
        $data->is_verify = 1;



        $cover = $request->file('cover');
        $file = $request->file('file');

        if ($cover) {

            //Storage::delete($data->cover);

            $namacover = $cover->getClientOriginalName();
            $cover->move('cover', $namacover);
            $data->cover = $namacover;
        }

        if($file)
        {
            $namafile = rand(999,9999) . $file->getClientOriginalName();
            $file->move('filebook', $namafile);
            $data->file = $namafile;
        }

        //dd($data);
    
        $data->save();

        \Session::flash('sukses', 'Data Buku berhasil diubah !');

        return redirect('book');
    }

    public function addreview(Request $request, Book $post)
    {
        $request->validate([
            'text' => 'required'
        ]);

        $data = new Comment();
        $data->user_id = Auth::id();
        $data->book_id = $post->id;
        $data->text = $request->text;
        $data->role_id = 2;

        //dd($data);
        $data->save();

        \Session::flash('sukses','Terimakasih atas reviewnya!');

        return redirect()->bacK();
    }

    public function delete($id)
    {
        try {
            Book::find($id)->delete();

            \Session::flash('sukses', 'Data berhasil dihapus !');
        } catch (\Exception $e) {
            \Session::flash('gagal', $e->getMessage());
        }

        return redirect()->back();
    }
}
