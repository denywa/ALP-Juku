import 'package:flutter/material.dart';
import 'navbar.dart'; // Pastikan Navbar diimpor dengan benar
import 'package:apk/pesanan_screen.dart';
import 'package:apk/keranjang_screen.dart';
import 'package:apk/dashboard_screen.dart';
import 'dart:convert';
import 'login_screen.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:apk/service/auth_service.dart'; // Import AuthService
import 'package:apk/service/user_service.dart'; // Import UserService
import 'package:apk/service/user_model.dart'; // Import UserModel
import 'editprofil_tambak.dart';
import 'kelola_produk.dart';
import 'pesanan_tambak.dart';

class MenuScreen extends StatefulWidget {
  @override
  _MenuScreenState createState() => _MenuScreenState();
}

class _MenuScreenState extends State<MenuScreen> {
  int _currentIndex = 3; // Indeks halaman yang sedang aktif
  UserModel? userData; // Variable to store user data

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
    _loadUserData(); // Load user data on initialization
  }

  void _loadUserData() {
    final userService = UserService();
    userService.getCurrentUser().then((user) {
      if (user != null) {
        setState(() {
          userData = user;
        });
      }
    });
  }

  void _onItemTapped(int index) {
    setState(() {
      _currentIndex = index;
    });
  }

  void _logout() async {
    final authService = AuthService();
    await authService.logout(); // Menggunakan AuthService untuk logout

    Navigator.pushAndRemoveUntil(
      context,
      MaterialPageRoute(builder: (context) => LoginScreen()),
      (Route<dynamic> route) => false, // Menghapus semua route sebelumnya
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: PreferredSize(
        preferredSize: const Size.fromHeight(60),
        child: AppBar(
          backgroundColor: Colors.white,
          surfaceTintColor: Colors.white,
          elevation: 0,
          flexibleSpace: Padding(
            padding: const EdgeInsets.only(
                top: 10.0, left: 16.0, right: 16.0), // Added left padding
            child: Row(
              mainAxisAlignment: MainAxisAlignment
                  .spaceBetween, // Align items to space between
              children: [
                const Padding(
                  padding: EdgeInsets.only(right: 16.0),
                  child: Text(
                    'AKUN',
                    style: TextStyle(
                      fontSize: 20,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                ),
                const SizedBox(width: 16), // Add space between text and logo
                Center(
                  // Center the logo vertically
                  child: Image.asset(
                    'assets/logo.png',
                    height: 50,
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
            child: ClipOval(
              child: userData?.image != null
                  ? Image.network(
                      userData!.image!,
                      width: 100,
                      height: 100,
                      fit: BoxFit.cover,
                      errorBuilder: (context, error, stackTrace) {
                        return Icon(
                          Icons.person,
                          size: 60,
                          color: Colors.black,
                        );
                      },
                      loadingBuilder: (context, child, loadingProgress) {
                        if (loadingProgress == null) return child;
                        return Center(
                          child: CircularProgressIndicator(
                            value: loadingProgress.expectedTotalBytes != null
                                ? loadingProgress.cumulativeBytesLoaded /
                                    loadingProgress.expectedTotalBytes!
                                : null,
                          ),
                        );
                      },
                    )
                  : Icon(
                      Icons.person,
                      size: 60,
                      color: Colors.black,
                    ),
            ),
          ),
          SizedBox(height: 10),
          Text(
            userData?.name ?? '',
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
                  leading: Icon(Icons.business),
                  title: Text('Edit Profil Bisnis'),
                  onTap: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                          builder: (context) => EditProfilTambakPage()),
                    );
                  },
                ),
                ListTile(
                  leading: Icon(Icons.store),
                  title: Text('Kelola Produk'),
                  onTap: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) => ProductManagementPage(),
                      ),
                    );
                  },
                ),
                ListTile(
                  leading: Icon(Icons.list),
                  title: Text('List Pesanan'),
                  onTap: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) => PesananTambakPage(),
                      ),
                    );
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
