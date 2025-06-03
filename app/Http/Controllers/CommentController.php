<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Comment;

class CommentController extends Controller
{
     /**
     * - Validasi input komentar ('comment' wajib diisi dan maksimal 1000 karakter)
     * - Simpan komentar baru pada artikel tertentu, relasikan dengan user yang sedang login
     * - Tampilkan pesan sukses dan redirect ke halaman detail artikel
     */
    public function store(Request $request, Article $article)
    {
        $request->validate([
            'comment' => 'required|max:1000'
        ]);
        $articleId = $comment->article_id;
        $comment->store();


        session()->flash('success', 'Comment berhasil diisi!');
        return redirect()->route('articles.show', ['article' => $articleId]);
    }

    public function destroy(Comment $comment) {
        $articleId = $comment->article_id;
        $comment->delete();
    
        session()->flash('success', 'Comment berhasil dihapus!');
        return redirect()->route('articles.show', ['article' => $articleId]);
    }
}
