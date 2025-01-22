import 'package:flutter/material.dart';
import 'navbar.dart'; // Pastikan Navbar diimpor dengan benar
import 'package:apk/pesanan_screen.dart';
import 'package:apk/keranjang_screen.dart';
import 'package:apk/dashboard_screen.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'login_screen.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:apk/service/auth_service.dart'; // Import AuthService

class MenuScreen extends StatefulWidget {
  @override
  _MenuScreenState createState() => _MenuScreenState();
}

class _MenuScreenState extends State<MenuScreen> {
  int _currentIndex = 3; // Indeks halaman yang sedang aktif

  // Daftar halaman yang akan dipilih berdasarkan indeks
  final List<Widget> _screens = [
    DashboardScreen(),
    PesananScreen(),
    KeranjangScreen(),
    MenuScreen(),
  ];

  @override
  void initState() {
    super.initState();
  }

  void _onItemTapped(int index) {
    setState(() {
      _currentIndex = index;
    });
  }

  void _logout() async {
    final authService = AuthService();
    await authService.logout(); // Menggunakan AuthService untuk logout

    Navigator.pushReplacement(
      context,
      MaterialPageRoute(builder: (context) => LoginScreen()),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: PreferredSize(
        preferredSize: const Size.fromHeight(140),
        child: AppBar(
          backgroundColor: Colors.white,
          elevation: 0,
          flexibleSpace: Padding(
            padding: const EdgeInsets.only(top: 10.0),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Center(
                  child: Image.asset(
                    'assets/logo.png',
                    height: 50,
                  ),
                ),
                const SizedBox(height: 8.0),
                const Text(
                  "AKUN",
                  style: TextStyle(
                    fontSize: 24,
                    fontWeight: FontWeight.bold,
                    color: Colors.black,
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
      body: Column(
        children: [
          SizedBox(height: 20),
          CircleAvatar(
            radius: 50,
            backgroundColor: Colors.grey.shade300,
            child: Icon(
              Icons.person,
              size: 60,
              color: Colors.black,
            ),
          ),
          SizedBox(height: 10),
          Text(
            'Felicia',
            style: TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold,
            ),
          ),
          SizedBox(height: 30),
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 24.0),
            child: Column(
              children: [
                ListTile(
                  leading: Icon(Icons.person),
                  title: Text('Informasi Pribadi'),
                  onTap: () {
                    Navigator.pushNamed(context, '/informasi');
                  },
                ),
                ListTile(
                  leading: Icon(Icons.history),
                  title: Text('Riwayat Pemesanan'),
                  onTap: () {
                    Navigator.pushNamed(context, '/riwayat');
                  },
                ),
                ListTile(
                  leading: Icon(Icons.store),
                  title: Text('Kelola Produk'),
                  onTap: () {
                    // Navigasi bisa ditambahkan di sini jika perlu
                  },
                ),
              ],
            ),
          ),
          Spacer(),
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 24.0),
            child: ListTile(
              leading: Icon(Icons.logout),
              title: Text('Logout'),
              onTap: _logout, // Logout logic menggunakan AuthService
            ),
          ),
          SizedBox(height: 20),
        ],
      ),
      bottomNavigationBar: Navbar(
        currentIndex: _currentIndex, // Tab yang aktif
        onTap: _onItemTapped, // Menangani perubahan tab
      ),
    );
  }
}
