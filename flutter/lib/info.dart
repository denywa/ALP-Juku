import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'dart:io';
import 'service/user_service.dart';
import 'service/user_model.dart';

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Informasi Pribadi',
      theme: ThemeData(
        primarySwatch: Colors.blue,
      ),
      home: const MenuScreen(),
    );
  }
}

class MenuScreen extends StatelessWidget {
  const MenuScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Menu Screen"),
        backgroundColor: Colors.blue,
      ),
      body: Center(
        child: ElevatedButton(
          onPressed: () {
            Navigator.push(
              context,
              MaterialPageRoute(builder: (context) => const InformasiScreen()),
            );
          },
          child: const Text("Go to Informasi Pribadi"),
        ),
      ),
    );
  }
}

class InformasiScreen extends StatelessWidget {
  const InformasiScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Informasi Pribadi"),
        backgroundColor: Colors.white,
        surfaceTintColor: Colors.white, // Important for Material 3

        leading: IconButton(
          icon: const Icon(Icons.arrow_back),
          onPressed: () {
            Navigator.pop(context);
          },
        ),
      ),
      body: const InformasiPribadiPage(),
    );
  }
}

class InformasiPribadiPage extends StatefulWidget {
  const InformasiPribadiPage({super.key});

  @override
  State<InformasiPribadiPage> createState() => _InformasiPribadiPageState();
}

class _InformasiPribadiPageState extends State<InformasiPribadiPage> {
  bool isEditing = false;
  bool isLoading = true;
  File? _image;
  UserModel? userData;
  final ImagePicker _picker = ImagePicker();
  final UserService _userService = UserService();

  final TextEditingController fullNameController = TextEditingController();
  final TextEditingController phoneNumberController = TextEditingController();
  final TextEditingController emailController = TextEditingController();

  @override
  void initState() {
    super.initState();
    _loadUserData();
  }

  Future<void> _loadUserData() async {
    setState(() {
      isLoading = true;
    });

    try {
      final user = await _userService.getCurrentUser();
      if (user != null) {
        setState(() {
          userData = user;
          fullNameController.text = user.name;
          phoneNumberController.text = user.phone ?? '';
          emailController.text = user.email;
        });
      }
    } catch (e) {
      // Handle error - show snackbar or dialog
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Gagal memuat data pengguna')),
      );
    } finally {
      setState(() {
        isLoading = false;
      });
    }
  }

  Future<void> _pickImage(ImageSource source) async {
    try {
      final XFile? pickedFile = await _picker.pickImage(source: source);
      if (pickedFile != null) {
        setState(() {
          _image = File(pickedFile.path);
        });
      }
    } catch (e) {
      debugPrint('Error picking image: $e');
    }
  }

  void _showImageSourceDialog() {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return AlertDialog(
          title: const Text('Pilih Sumber Gambar'),
          content: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              ListTile(
                leading: const Icon(Icons.photo_library),
                title: const Text('Galeri'),
                onTap: () {
                  Navigator.pop(context);
                  _pickImage(ImageSource.gallery);
                },
              ),
            ],
          ),
        );
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    if (isLoading) {
      return const Center(child: CircularProgressIndicator());
    }

    return Padding(
      padding: const EdgeInsets.all(16.0),
      child: Card(
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(12.0),
        ),
        elevation: 4,
        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Row(
                children: [
                  GestureDetector(
                    onTap: isEditing ? _showImageSourceDialog : null,
                    child: Stack(
                      children: [
                        CircleAvatar(
                          radius: 25,
                          child: _image != null
                              ? ClipOval(
                                  child: Image.file(
                                    _image!,
                                    width: 50,
                                    height: 50,
                                    fit: BoxFit.cover,
                                  ),
                                )
                              : (userData?.image != null
                                  ? ClipOval(
                                      child: Image.network(
                                        userData!.image!,
                                        width: 50,
                                        height: 50,
                                        fit: BoxFit.cover,
                                        errorBuilder:
                                            (context, error, stackTrace) {
                                          return const Icon(
                                              Icons.account_circle,
                                              size: 50);
                                        },
                                      ),
                                    )
                                  : const Icon(Icons.account_circle, size: 50)),
                        ),
                        if (isEditing)
                          Positioned(
                            right: 0,
                            bottom: 0,
                            child: Container(
                              padding: const EdgeInsets.all(2),
                              decoration: BoxDecoration(
                                color: Colors.blue,
                                borderRadius: BorderRadius.circular(10),
                              ),
                              child: const Icon(
                                Icons.camera_alt,
                                size: 12,
                                color: Colors.white,
                              ),
                            ),
                          ),
                      ],
                    ),
                  ),
                  const SizedBox(width: 16),
                  Text(
                    userData?.name ?? '',
                    style: const TextStyle(
                      fontSize: 20,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                  const Spacer(),
                  IconButton(
                    icon: Icon(isEditing ? Icons.close : Icons.edit),
                    onPressed: () {
                      setState(() {
                        isEditing = !isEditing;
                        if (!isEditing) {
                          // Reset controllers to original data if canceling
                          fullNameController.text = userData?.name ?? '';
                          phoneNumberController.text = userData?.phone ?? '';
                          emailController.text = userData?.email ?? '';
                        }
                      });
                    },
                  ),
                ],
              ),
              const SizedBox(height: 16),
              const Text(
                'Informasi Pribadi',
                style: TextStyle(
                  fontSize: 16,
                  fontWeight: FontWeight.bold,
                ),
              ),
              const SizedBox(height: 8),
              buildTextField('Nama Lengkap', fullNameController, isEditing),
              const SizedBox(height: 8),
              buildTextField('No. telepon', phoneNumberController, isEditing),
              const SizedBox(height: 8),
              buildTextField('Email', emailController, isEditing),
              if (isEditing) ...[
                const SizedBox(height: 16),
                Row(
                  mainAxisAlignment: MainAxisAlignment.end,
                  children: [
                    ElevatedButton(
                      onPressed: () {
                        setState(() {
                          isEditing = false;
                          // Reset data to original values
                          _loadUserData();
                        });
                      },
                      style: ElevatedButton.styleFrom(
                        backgroundColor: Colors.grey,
                      ),
                      child: const Text('Batal'),
                    ),
                    const SizedBox(width: 8),
                    ElevatedButton(
                      onPressed: () {
                        // TODO: Implement save functionality
                        setState(() {
                          isEditing = false;
                        });
                      },
                      child: const Text('Simpan'),
                    ),
                  ],
                ),
              ],
            ],
          ),
        ),
      ),
    );
  }

  Widget buildTextField(
      String label, TextEditingController controller, bool isEnabled) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          label,
          style: const TextStyle(fontSize: 14, color: Colors.grey),
        ),
        const SizedBox(height: 4),
        TextField(
          controller: controller,
          enabled: isEnabled,
          decoration: InputDecoration(
            border: OutlineInputBorder(
              borderRadius: BorderRadius.circular(8.0),
            ),
            filled: true,
            fillColor: isEnabled ? Colors.white : Colors.grey[200],
          ),
          style: const TextStyle(fontSize: 14),
        ),
      ],
    );
  }
}
