# 03 - Module sample

[link source code](https://gitlab.com/pirago/magento-demo) 
**Đọc các bài hướng dẫn cơ bản [tại đây](https://www.mageplaza.com/magento-2-module-development/)
![](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/edc86746-cb2a-464d-9782-daaae6e7c798/image.png)


## Yêu cầu

clone lại module Sizechart từ Mageplaza, tổng quan, giới thiệu và demo xem 
[tại đây](https://www.mageplaza.com/magento-2-size-chart/)

## Tổng quát các bước

1. Đăng kí, khởi tạo module
1. Tạo CSDL, Model, Resource Model và Collection để thao tác với dữ liệu
1. Menu & Configuration
1. Quản lý Rule trong admin
1. Tạo nhiều storeview để test
1. Logic hiển thị sizechart cho 3 kiểu hiển thị (popup, inline, tab)


## Đăng kí, khởi tạo module

Tạo một module mới với tên PiraGo_SizeChart, version 1.0.0.
* PiraGo là _namespace / company / vendor name_
* SizeChart là tên module

Thư mục: _app/code/PiraGo/SizeChart_

1. tạo file _app/code/PiraGo/SizeChart/registration.php:_


2. tạo file _app/code/PiraGo/SizeChart/etc/module.xml:_

**node sequence thể hiện dependency của module core Magento_Catalog

## Tạo CSDL, Model, Resource Model và Collection để thao tác với dữ liệu

1. **Tạo bảng CSDL**

  Tạo bảng tên "sizechart_rules" trong phpmyadmin để lưu trữ danh sách rule. 
  Sau đó tạo file setup bảng (_app/code/PiraGo/SizeChart/Setup/InstallSchema.php_) Bảng gồm các cột sau:
![chụp từ phpmyadmin](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/aa70d809-2373-4f2a-9735-cda750e68451/image.png)
 **file InstallSchema chỉ chạy một lần lúc setup module nên muốn thêm cột hoặc data thì phải tạo file upgradeSchema, lưu ý đến thống số setup_version trong file module.xml khi upgrade tìm hiểu [ở đây](https://www.mageplaza.com/magento-2-module-development/magento-2-how-to-create-sql-setup-script.html)
2. **Tạo CRUD Model (Create, Read, Update, Delete)**
**kiến thức về ORM tìm hiểu [ở đây](https://blog.magestore.com/magento-orm/)
Tạo model, resource model, collection để thao tác với dữ liệu trong bảng sizechart_rules:
* _PiraGo\SizeChart\Model\Rule.php_
* _PiraGo\SizeChart\Model\ResourceModel\Rule.php_
* _PiraGo\SizeChart\Model\ResourceModel\Rule\Collection.php_

**Resource Model trực tiếp thực hiện truy vấn đến bảng và định nghĩa Model nào sẽ kết nối với bảng đó để thao tác, Collection Model coi như là Resurce Model cho phép truy vấn và lọc nhiều hàng trong bảng. Tìm hiểu thêm [ở đây](https://www.mageplaza.com/magento-2-module-development/how-to-create-crud-model-magento-2.html)
3. **Tạo Route controller để test Model trên**
**kiến thức về Routing tìm hiểu [ở đây](https://www.mageplaza.com/magento-2-module-development/magento-2-routing.html)
đường dẫn controller theo cú pháp sau front_name/controller_name/action_name
Để test truy vấn qua Model vào phpmyadmin tạo một vài dòng dữ liệu. Sau đó tạo Controller: 
_PiraGo\SizeChart\Controller\Index\Index.php_

## Menu & Configuration

1. **Admin menu**


![menu](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/c8ecd4a2-7175-4dbd-b2dc-4122cd1feeec/image.png)
* Menu parent: Size Chart dưới đó có 2 menu con 

 +Manage Rules: Dẫn tới trang quản lý Rule (Grid). Action: sizechart\rule\index
tạo file _PiraGo/SizeChart/etc/adminhtml/menu.xml_
 +Configuration: Dẫn tới trang cấu hình của module SizeChart (Configuration sẽ làm ở phần sau). Action adminhtml/system_config/edit/section/sizechart
* Tạo resource acl (access control list)

+tạo file _PiraGo/SizeChart/etc/acl.xml_
**là bước tạo resource cho cây acl như là tạo các quyền để phân quyền truy cập cho các user khác nhau, attribute 'resource' của node <add> trong menu.xml là để gán quyền vào menu. Tức user có quyền đó mới truy cập được menu đó. 
2.  **Configuration**
![](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/f0af0f0f-c143-4ab8-ad6e-502e9befd582/image.png)

Tạo trang cấu hình cho module (system.xml) với các field sau:
* Enable SizeChart (yes/no): bật/tắt tính năng sizechart. Nếu field này là NO, toàn bộ các tính năng của module ngoài frontend sẽ không hoạt động.
* Link icon: cấu hình image cạnh popup link ở frontend 

tạo file  _PiraGo/SizeChart/etc/adminhtml/system.xml_
**node <backend_model> để cấu hình model thao tác với dữ liệu kiểu image, image sẽ được lưu trong thư mục được cấu hình trong node <upload_dir>. Khi lấy đường dẫn ảnh để hiển thị thì dùng storeManager->getStore()->getBaseUrl. Xem function getPath() ở file PiraGo/SizeChart/Block/SizeChart1.php


## Quản lý Rule trong admin

1. ** Tạo Grid quản lý SizeChart Rules**

-Action: sizechart\rule\index
```
+tạo layout file _PiraGo/SizeChart/view/adminhtml/layout/pirago_sizechart_rule_index.xml_
+tạo ui component layout file _PiraGo/SizeChart/view/adminhtml/ui_component/pirago_sizechart_rule_edit.xml_

```
-Sử dụng UI Component tạo grid để quản lý SizeChart Rule với các function cơ bản:
* Nút New Rule trang form tạo rules. Action: sizechart\rule\new


![cấu hình nút add new rule](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/8eb88d5c-7061-4e93-86a3-d44c23cb7516/image.png)

* Cấu hình các nút ở dưới nút Add New Rule 


![](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/08acf242-0624-4bb3-9d4b-e17bb0de8343/image.png)
<filters> để lọc nhanh dữ liệu 
<paging> để phân trang
<columnsControls> để bật tắt hiển thị các cột
* Các massActions: Delete, Change Status 

 cấu hình trong node <massaction name="listing_massaction">

![](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/0987cbde-17af-4aa6-a8e4-7c7c0141c99c/image.png)
Các controller handle các massAction trên: pirago/rule/massDelete và pirago/rule/massStatus

* Edit column: Mỗi row sẽ có action edit để dẫn tới trang edit rules đó - sizechart\rule\edit_PiraGo\SizeChart\Ui\Component\Listing\Column\Actions.php_ thêm một cột action vào grid 

![](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/93b1519d-0358-4cd8-982b-abc8420f471d/image.png)

* Inline Edit: admin có thể sửa nhanh một cột trong grid 


![inline edit](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/db678a89-4dad-43ba-9104-99f134fe0b22/image.png)

![](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/0b93167c-b105-4832-8baa-c00ce467534b/image.png)
**cấu hình trong node <columns name="spinner_columns">
controller pirago/rule/inlineEdit handle action này
* xong cấu hình grid

![](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/84e382a5-cc7f-413c-9603-d234701b9e66/image.png)

**tìm hiểu thêm [tại đây](https://www.mageplaza.com/magento-2-module-development/create-admin-grid-magento-2.html)
2. **Tạo Form & Save Rules**
* **Tạo Form**

  **có 2 trường hợp tạo new rule hoặc edit rule. New rule thì các field sẽ trắng, còn edit rule thì các field được đổ vào dữ liệu tương ứng với rule id.  
+đầu tiên tạo layout handle action sizechart/rule/edit. Vì cấu hình form gồm 4 tab nên trong đó khai báo các block tương ứng vơí mỗi tab khác nhau. Mỗi tab gồm một vài field. Chú ý đến các node <referenceblock> thể hiện ghi đè lên layout core của magento 
+tiếp theo tạo Block/Adminhtml/Code/Edit.php: thể hiện khai báo block của form container: trong file có câu lệnh thêm nút Save and Continute Edit.
+tiếp theo tạo Block/Adminhtml/Code/Edit/Tab.php: khai báo block tab lớn bên trái layout editing page.
+tiếp tạo Block/Adminhtml/Code/Edit/Form.php: khai báo thông tin form như id, action form.
+Block/Adminhtml/Code/Edit/Tab/Code.php: tạo field trong tab con thứ 1 qua hàm addFieldset().
Chú ý đến các kiểu field. Trong tab này có field Storeview là multiselect thì key 'values' sẽ chỉ đến giá trị trong core để lấy ra các option về storeview. Nếu là form edit, đổ dữ liệu field dạng multiselect kiểu array phải chuyển php array sang js array

![đổ dữ liệu dạng mutiselect](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/1702069d-0435-42a9-9285-735a76d5e34b/image.png)

+Block/Adminhtml/Code/Edit/Tab/What.php: block này có field Template html là field dạng WYSIWYG editor cho phép soạn siêu văn bản. Ở tab này có thêm một button Load để call ajax load dữ liệu đổ vào field Template html. Thêm đoạn code cho nút Load trong key " after_element_html" 
![ajax call](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/c69de652-5eca-4ea3-b9fa-f707835f22dd/image.png)
tinyMCE.get().setContent() để convert script html thành giao diện.
+Block/Adminhtml/Code/Edit/Tab/Conditions.php: có field tạo dữ liệu kiểu condition cho rule. Để đọc và ghi được field này class model phải khai bào các dependency qua contruct thêm các class \Magento\CatalogRule\Model\Rule\Condition\CombineFactory, \Magento\CatalogRule\Model\Rule\Condition\ProductFactory
**để render thêm các conditions khi ấn vào dấu cộng phải có action sizechart/rule/NewConditionHtml.php 

![conditions field](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/70317267-aac0-4fad-92ec-3795cda924c5/image.png)
+Block/Adminhtml/Code/Edit/Tab/How.php: tab này có field kiểu mutiselect phải convert sang string mới lưu được vào database. Khi edit form để render ra mutilselect field thì phải chuyển string -> php array ->js array. 
![](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/7b83122a-ecee-4e90-962e-7158b88663d2/image.png)
* **Save Rules**

 Action: sizechart/rule/Save 
Logic save rules: Để lưu conditions dùng method LoadPost() nên các field kiểu multiselect phải lưu trước vì phải qua bước convert sang String mới lưu được. Hàm prepareData() thao tác để lưu conditions.
Logic chuyển hướng sau khi lưu: nếu ấn nút Save and Continue Edit thì chuyển hướng lại trang edit với param id, còn ấn nút Save thì chuyển về trang grid.  

## Tạo nhiều storeview để test

**storeview khác nhau sẽ áp dụng rule khác nhau, nên tạo nhiều storeview để test
[https://devdocs.magento.com/guides/v2.3/config-guide/multi-site/ms_websites.html](https://devdocs.magento.com/guides/v2.3/config-guide/multi-site/ms_websites.html)

## Hiển thị sizechart cho 3 kiểu hiển thị (popup, inline, tab)

1. **Logic hiển thị**

  ** trước khi chạy vào block 'product view' thì tìm một rule thích hợp nhất được áp dụng, 
  **hình dưới thể hiện logic đó: lặp tìm kiếm tất cả các rule nếu rule và product thỏa mãn về storeview, điều kiện conditions thì xét đến thuộc tính priority để lấy ra rule ưu tiên nhất. 
  **file PiraGo/SizeChart/Observer/DisplayType.php : là class observer xử lí event          layout_generate_blocks_before sẽ chạy ngay trước khi block được chạy
![](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/49c7eeca-b524-4df5-a382-0a955f52009f/image.png)
  **sau khi chọn được rule thích hợp nhất thì sẽ truyền đi những dữ liệu cần thiết để hiện thị rule đó ra màn hình như kiểu hiện thị là gì? template html? template css?
  **các giá trị sẽ truyền thông qua Registry để đưa đến các block tương ứng xử lí là các block SizeChart1 và Inline

![](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/88407765-18f2-493f-ae8c-5aaff705806d/image.png)
2. **Override block layout cho các kiểu hiển thị**
file: PiraGo/SizeChart/view/frontend/layout/catalog_product_view.xml
**để hiển thị ra frontend phải tìm đến những layout core để ghi đè lên, trong trường hợp này là layout catalog_product_view
* hiển thị kiểu popup:  hình dưới thể hiện thêm action setTemplate() có nhiệm vụ thêm template "PiraGo_SizeChart::form.phtml "vào block "product.info" 

![](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/68a955fd-94f8-477e-8572-321b75a03d3e/image.png)

![](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/c631ec23-30e7-49eb-93e8-8a0871cfc4e5/image.png)

* hiển thị kiểu tab: block SizeChart1 extend block core là \Magento\Catalog\Block\Product\View để thêm vài function về logic hiển thị 


![](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/8159dc85-5b26-4629-91fe-87633e127adb/image.png)
node <preference> trong di.xml thể hiện block SizeChart1 override block Product\View  
![](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/bb70a958-7799-4cbc-938b-291837dab7b5/image.png)

![](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/786569d4-3671-4b21-bf9d-01ad326e25a3/image.png)
* hiển thị kiểu inline: tương tự node <referenceContainer> thể hiện block Inline được thêm vào Container đó kèm theo là template Inline.phtml chứa nội dung hiển thị

![](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/99e8eaf4-50f3-4cfd-bc8b-4038ee01eb67/image.png)

![](https://s3-ap-southeast-1.amazonaws.com/pirago-outline/uploads/e6d660df-8092-470e-9244-6a91b83b11b5/0ea3feeb-8d5f-41f6-adee-f7d087c20ebe/image.png)