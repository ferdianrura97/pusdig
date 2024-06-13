<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function simaksi(Request $request)
    {
        try {
            $this->validate($request, [
                'judul' => 'required',
                'ringkasan' => 'required',
                'file' => 'required',
                'cover' => 'required',
                'penulis' => 'required',
                'penerbit' => 'required',
                'simaksi_code' => 'required',
                'jml_halaman' => 'required',
            ]);

            $buku = Book::where('simaksi_code', $request->simaksi_code)->first();
            $cover = $request->file('cover');
            $file = $request->file('file');

            if ($cover) {
                $coverExtension = $cover->getClientOriginalExtension();
                $coverName = pathinfo($cover->getClientOriginalName(), PATHINFO_FILENAME);
                $namacover = $coverName . '_' . time() . '_' . rand(1000, 9999) . '.' . $coverExtension;
                $cover->move(public_path('cover'), $namacover);
            }

            if ($file) {
                $fileExtension = $file->getClientOriginalExtension();
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $namafile = $fileName . '_' . time() . '_' . rand(1000, 9999) . '.' . $fileExtension;
                $file->move(public_path('filebook'), $namafile);
            }

            $data = [
                'judul' => $request->judul,
                'slug' => Str::slug($request->judul),
                'user_id' => 1,
                'ringkasan' => $request->ringkasan,
                'cover' => $namacover ?? null,
                'file' => $namafile ?? null,
                'penulis' => $request->penulis,
                'penerbit' => $request->penerbit,
                'jml_halaman' => $request->jml_halaman,
                'simaksi_code' => $request->simaksi_code,
                'category_id' => 1,
                'is_verify' => 1,
            ];

            if ($buku) {
                $buku->update($data);

                return response()->json([
                    'status' => 'success',
                    'data' => $buku,
                ]);
            } else {
                $buku = Book::create($data);

                return response()->json([
                    'status' => 'success',
                    'data' => $buku,
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => "Ada Masalah: " . $th->getMessage(),
            ], 500);
        }
    }
}
