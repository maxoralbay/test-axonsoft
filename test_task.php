<?php
/***
 * Есть плоский массив с элементами содержащими уникальный идентификатор
 * и идентификатор родительского элемента, необходимо построить
 * "деревовидную" структуру. Пример:
 * [
 * [
 * id: [0-9],
 * parent_id: [0-9]
 * ],
 * ...
 * ]
 * @param $flatArray
 * @param $parentId
 * @return array
 */
function buildTree($flatArray, $parentId = null)
{
    $tree = array();

    foreach ($flatArray as $item) {
        if ($item['parent_id'] == $parentId) {
            $childNode = array(
                'id' => $item['id'],
                'childs' => buildTree($flatArray, $item['id'])
            );
            $tree[] = $childNode;
        }
    }

    return $tree;
}

$flatArray = array(
    array('id' => 1, 'parent_id' => null),
    array('id' => 2, 'parent_id' => 1),
    array('id' => 3, 'parent_id' => 1),
    array('id' => 4, 'parent_id' => 2),
    array('id' => 5, 'parent_id' => null),
    array('id' => 6, 'parent_id' => 5),
);

$tree = buildTree($flatArray);
print_r($tree);


/***
 * Необходимо конвертировать чиcло в excel координату колонки. Пример:
 * 1 => A
 * 2 => B
 * 27 => AA
 * 28 => AB
 * @param $number
 * @return string
 */
function numbertoexcelcordinate($number)
{
    $abc = array_flip(range('A', 'Z'));
    $result = '';
    $number = $number - 1;
    //print_r($abc);
    while ($number >= 0) {
        $result = array_keys($abc)[($number % 26)] . $result;
        $number = floor($number / 26) - 1;
    }
    return $result;
}

function print_result($number, $symbol)
{
    echo numbertoexcelcordinate($number) == $symbol ? 'OK' : 'FAIL';
}

// Test
print_result(1, 'A');
print_result(2, 'B');
print_result(27, 'AA');
print_result(28, 'AB');
