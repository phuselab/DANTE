<img src="img/dante1.png"  width="80%">

***Giuseppe Boccignone¹, Donatello Conte², Vittorio Cuculo¹, Raffaella Lanzarotti¹***  
¹ [PHuSe Lab](https://phuselab.di.unimi.it) - Dipartimento di Informatica, Università degli Studi di Milano  
² Université de Tours - Tours, France

**Paper** *Boccignone, G., Conte, D., Cuculo, V. and Lanzarotti, R. (2017) AMHUSE: A Multimodal dataset for HUmour SEnsing. In Proceedings of 19th ACM International Conference on Multimodal Interaction. (ICMI'17), ACM*  

https://dl.acm.org/doi/10.1145/3136755.3136806

## Description
DANTE (Dimensional ANnotation Tool for Emotions) is a project developed by the [PHuSe Lab](http://phuselab.di.unimi.it "PHuSe Lab") from Università degli Studi di Milano, Italy, in collaboration with Département Informatique de Ecole Polytechnique de l'Université François Rabelais de Tours, France. The tool is part of a multimodal dataset acquired with the aim to study emotional response in presence of amusement stimulus.

<a href="http://phuselab.di.unimi.it/DANTE/default.html"><img src="img/logo.png" alt="logo" height="50px"></a>  <a href="http://phuselab.di.unimi.it/"><img src="img/logo_phuse_1b_fit.png" alt="logo" height="50px"></a>  <a href="http://www.unimi.it/"><img src="img/logo_uni1.png" alt="logo" height="50px"></a>  <a href="http://www.univ-tours.fr/"> <img src="img/logo_uni2.png" alt="logo" height="50px"></a>

## Demo

For a test demo, go to the following link:

http://phuselab.di.unimi.it/DANTE/index.php?id=3497&vid=30_3.mp4&type=arousal

<img src="img/dante2.png"  width="80%">

## Requirements
The annotation tool is a web-based software, and for this reason it simply requires a LAMP/MAMP/WAMP software bundle, depending on the operating system. In other terms, it requires: **Apache HTTP Server**, **MySQL** and **PHP**.

## Installation
1. Clone the repository
```sh
git clone https://github.com/PHuSeLab/DANTE.git
```
2. Copy or move the `DANTE` folder to the Apache `www` folder.
3. Import the `annotationdb.sql` file into an existing MySQL instance.  
This is step is needed to create the DANTE database and tables.
```sh
mysql -u <username> -p < annotationdb.sql
```
5. Edit the file `config.php` according to the environment. (For more details, see section [configuration](#config)).
6. Open the browser to the page `http://localhost/login.php` or wherever you installed DANTE.
7. Login with default credentials `admin:admin`.
8. Follow the configuration instructions and **change the default password**!


## <a name="config"></a>Configuration
The configuration file contained in `config.php` is very simple and permits to configure some basics parameters, such as:
- `db_host` hostname of the MySQL database (default: localhost).
- `db_name` database name to use, where the annotationdb.sql file is imported (default: annotationdb).
- `db_user` MySQL database username.
- `db_pass` MySQL database password.
- `anno_rate` annotation recording frequency. DANTE will record a value every 1/anno_rate seconds (default: '25').
- `save_mode` DANTE is able to save the annotations to the database `db` or to a text file `file` (default: 'db'). Before using `file` mode check permission of the `annotation` folder.

## Reference

If you use this code or data, please cite the paper:

```
@inproceedings{cuculo2019openfacs,
    author="Cuculo, Vittorio and D'Amelio, Alessandro",
    editor="Zhao, Yao and Barnes, Nick and Chen, Baoquan and Westermann, R{\"u}diger and Kong, Xiangwei and Lin, Chunyu",
    title="OpenFACS: An Open Source FACS-Based 3D Face Animation System",
    booktitle="Image and Graphics",
    year="2019",
    publisher="Springer International Publishing",
    address="Cham",
    pages="232--242",
}
```
