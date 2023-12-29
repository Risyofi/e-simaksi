<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pendaftaran;
use App\Models\Trail;
use App\Models\Pendaki;

class TicketController extends Controller
{
    public function index() {
        $registrations = pendaftaran::with(['pendaki', 'trail'])->get();
        $trails = Trail::all();
        return view('ticket', [
            'title' => 'Tiket',
            'active' => 'none',
            'registrations' => $registrations,
            'trails' => $trails,
        ]);
    }

    public function show($id)
    {
        return view('ticket', [
            'title' => 'Detail Tiket',
            'registration' => $ticket,
        ]);
    }

    public function edit($id)
    {
        $registration = Pendaftaran::findOrFail(decrypt($id));
        $trails = Trail::all();

        return view('ticket.edit', [
            'title' => 'Edit Tiket',
            'active' => 'none',
            'registration' => $registration,
            'trails' => $trails,
        ]);
    }

    public function update(Request $request, $id)
    {
        $registration = Pendaftaran::findOrFail(decrypt($id));
        $request->validate([
            'tanggal_naik' => 'required|date',
            'tanggal_turun' => 'required|date|after_or_equal:tanggal_naik',
            'trail_id' => 'required',
            'nama_pendaki' => 'required',
            'no_identitas' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Pria,Perempuan',
            'no_hp' => 'required|numeric',
            'alamat' => 'required',
            'nama_kontak_darurat' => 'required',
            'no_hp_kontak_darurat' => 'required|numeric',
            'alamat_kontak_darurat' => 'required',
            'hubungan_kontak_darurat' => 'required|in:Suami,Istri,Anak,Orang Tua,Saudara',
        ]);

        $registration->update([
            'tanggal_naik' => $request->tanggal_naik,
            'tanggal_turun' => $request->tanggal_turun,
            'trail_id' => $request->trail_id,
        ]);

        // Update data pendaki (assuming one-to-one relationship)
        $registration->pendaki->update([
            'name' => $request->nama_pendaki,
            'no_identitas' => $request->no_identitas,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        // Update data kontak darurat
        $registration->update([
            'name' => $request->nama_kontak_darurat,
            'no_hp' => $request->no_hp_kontak_darurat,
            'alamat' => $request->alamat_kontak_darurat,
            'hubungan' => $request->hubungan_kontak_darurat,
        ]);

        return redirect()->route('ticket.index')->with('success', 'Data berhasil disimpan.');
    }

    public function destroy($id)
    {
        $registration = pendaftaran::findOrFail(decrypt($id));
        $registration->delete();
        return redirect('/ticket')->with('danger', 'Data berhasil dihapus.');
    }

    
}
